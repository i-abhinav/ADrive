<?php

namespace App\Http\Controllers;
// use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Docs;
use App\Models\Folder;
use App\Models\User;
use Auth;
use File;
use Redirect;
use Request;
use Response;
use Session;
use Storage;
use Validator;
use View;

class HomeController extends Controller {

/**
 *@return Returns the User Home page after login
 */
	public function getHome() {
		if (Auth::check()) {
			$allData = User::with(['folders' => function ($q) {$q->whereNull('parent');},
				'files' => function ($q) {$q->whereNull('folder_id');}])
				->where('id', Auth::user()->id)->get();
			return view('home', compact('allData'));
		} else {
			return view('guest.login');
		}
	}

/**
 *@return Handle the create new folder request
 */
	public function postAddFolder() {
		$rules = [
			'folder_name' => 'required|min:2|max:50',
		];

		$validator = Validator::make(Request::all(), $rules);
		if ($validator->fails()) {
			return $validator->messages()->first();
			// return response()->json(['errors'=>$validator->errors()->all()]);
		}
		$fid = Request::get('source');
		$parent = NULL;
		if (!empty($fid)) {
			$folder = Folder::where(['user_id' => Auth::user()->id, 'folder_uid' => $fid])->first();
			if (empty($folder)) {return "OOps, Something went wrong!!";}
			$parent = $folder->id;
		}
		$datetime = date('Y-m-d H:i:s');

		$folder = new Folder;
		$folder->folder_uid = bin2hex(openssl_random_pseudo_bytes(10));
		$folder->name = Request::get('folder_name');
		$folder->user_id = Auth::user()->id;
		$folder->parent = $parent;
		$folder->status = '1';
		$folder->created_at = $datetime;
		$folder->updated_at = $datetime;
		$folder->save();

		return 'success';

	}

/**
 *@return Handle the Open Folder request
 *@param $fid, string, Folder unique ID
 */
	public function getOpenFolder($fid) {
		if (!$fid) {return view('errors.404-error');}
		$source = Folder::where(['user_id' => Auth::user()->id, 'folder_uid' => $fid])->first();
		if (empty($source)) {return view('errors.404-error');}
		$folderData = User::with(['folders' => function ($q) use ($source) {$q->where('parent', $source->id);},
			'files' => function ($q) use ($source) {$q->where('folder_id', $source->id);}])
			->where('id', Auth::user()->id)->get();
		return view('folder', compact('source', 'folderData'));
	}

/**
 *@return Handle the Open Trash Folder request
 */
	public function getTrash() {
		// $allData = Folder::with('folders', 'documents')->where(['user_id' => Auth::user()->id, 'status' => '2'])->get();
		// return
		$allData = User::with('trash_folders', 'trash_files')
			->where('id', Auth::user()->id)->get();
		return view('trash', compact('allData'));
	}

/**
 *@return Handle the Move Folder to Trash request
 *@param $fid, string, Folder unique ID
 */
	public function getTrashFolder($fid) {
		if (!$fid) {return view('errors.404-error');}
		$dataExist = Folder::where(['user_id' => Auth::user()->id, 'folder_uid' => $fid, 'status' => '1'])->first();
		if (empty($dataExist)) {return view('errors.404-error');}
		Folder::where(['user_id' => Auth::user()->id, 'folder_uid' => $fid])->update([
			'status' => '2',
			'updated_at' => date('Y-m-d H:i:s'),
		]);
		Session::flash('swal_type', 'success');
		Session::flash('swal_title', 'Success!');
		Session::flash('swal_text', "Folder moved to Trash!!");
		return Redirect::back();
	}

/**
 *@return Handle the Delete Folder to permanently request
 *@param $fid, string, Folder unique ID
 */
	public function getDeleteFolder($fid) {
		if (!$fid) {return view('errors.404-error');}
		$dataExist = Folder::where(['user_id' => Auth::user()->id, 'folder_uid' => $fid, 'status' => '2'])->first();
		if (empty($dataExist)) {return view('errors.404-error');}
		Folder::where(['user_id' => Auth::user()->id, 'folder_uid' => $fid])->update([
			'status' => '3',
			'updated_at' => date('Y-m-d H:i:s'),
		]);
		Session::flash('swal_type', 'success');
		Session::flash('swal_title', 'Success!');
		Session::flash('swal_text', "Folder deleted permanently!");
		return Redirect::back();
	}

/**
 *@return Handle the Upload multiple Files request
 *@param Request $request file
 */
	public function postUploadFiles() {
		$uid = Auth::user()->id;

		// $rule = ['files.*' => 'required|max:2000|mimes:jpeg,png,jpg']; //size:2000kb=2Mb
		$rule = ['files' => 'required|max:20000']; //size:20000kb=20Mb

		$validator = Validator::make(Request::all(), $rule);
		if ($validator->fails()) {
			Session::flash('swal_type', 'warning');
			Session::flash('swal_title', 'Warning!');
			Session::flash('swal_text', "File is required and should be less than 20 MB");
			return Redirect::back()->withInput()->withErrors($validator);
		}
		$files = Request::file('files');

		$source = Request::get('source');
		$fid = NULL;
		if (!empty($source)) {
			$folder = Folder::where(['user_id' => Auth::user()->id, 'folder_uid' => $source])->first();
			if (empty($folder)) {return "OOps, Something went wrong!!";}
			$fid = $folder->id;
		}

		foreach ($files as $file) {
			$extension = $file->getClientOriginalExtension();
			$origfileName = $file->getClientOriginalName();
			$fileSize = $file->getSize();
			$mimeType = $file->getMimeType();
			$directory = Auth::user()->token;

			$destinationPath = storage_path() . "/docs/" . $directory;
			if (!File::exists($destinationPath)) {
				Storage::makeDirectory($destinationPath, $mode = 0755, $recursive = false, $force = false);
			}

			$filename = time() . bin2hex(openssl_random_pseudo_bytes(12)) . "." . $extension;

			$file->move($destinationPath, $filename);

			$datetime = date('Y-m-d H:i:s');

			$file = new Docs;
			$file->doc_id = bin2hex(openssl_random_pseudo_bytes(8));
			$file->name = $filename;
			$file->original_name = $origfileName;
			$file->user_id = $uid;
			$file->folder_id = $fid;
			$file->path = $destinationPath;
			$file->size = $fileSize;
			$file->extension = $extension;
			$file->mime = $mimeType;
			$file->status = '1';
			$file->created_at = $datetime;
			$file->updated_at = $datetime;
			$file->save();

		}

		Session::flash('swal_type', 'success');
		Session::flash('swal_title', 'Success!');
		Session::flash('swal_text', "File uploaded successfully!!");
		return Redirect::back();

	}

/**
 *@return Return Uploaded File for View or Download from storage folder, docs/token
 *@param $id, string
 */
	public function getViewFile($id) {
		if (!$id) {return view('errors.404-error');}
		$fileData = Docs::where(['user_id' => Auth::user()->id, 'doc_id' => $id, 'status' => '1'])->first();
		if (empty($fileData)) {return view('errors.404-error');}

		$directory = "docs/" . Auth::user()->token;
		$destinationPath = storage_path() . '/' . $directory;

		$path = $destinationPath . '/';
		$path .= $fileData->name;

		if (!File::exists($path)) {
			return view('errors.404-error');
		}

		$file = File::get($path);
		$type = File::mimeType($path);
		$response = Response::make($file, 200);
		$response->header("Content-Type", $type);
		return $response;

	}

	/**
	 *@return Return Uploaded File for View or Download from storage folder, docs/token
	 *@param $id, string
	 */
	public function getDownloadFile($id) {
		if (!$id) {return view('errors.404-error');}
		$fileData = Docs::where(['user_id' => Auth::user()->id, 'doc_id' => $id, 'status' => '1'])->first();
		if (empty($fileData)) {return view('errors.404-error');}

		$directory = "docs/" . Auth::user()->token;
		$destinationPath = storage_path() . '/' . $directory;

		$path = $destinationPath . '/';
		$path .= $fileData->name;

		if (!File::exists($path)) {
			return view('errors.404-error');
		}

		$type = File::mimeType($path);

		$headers = ["Content-Type: $type"];
		return response()->download($path, $fileData->original_name, $headers);
	}

/**
 *@return Move to File in Trash folder
 *@param $id, string, File unique ID
 */
	public function getTrashFile($id) {
		if (!$id) {return view('errors.404-error');}
		$fileData = Docs::where(['user_id' => Auth::user()->id, 'doc_id' => $id, 'status' => '1'])->first();
		if (empty($fileData)) {return view('errors.404-error');}
		Docs::where(['user_id' => Auth::user()->id, 'doc_id' => $id])->update([
			'status' => '2',
			'updated_at' => date('Y-m-d H:i:s'),
		]);
		Session::flash('swal_type', 'success');
		Session::flash('swal_title', 'Success!');
		Session::flash('swal_text', "File moved to Trash!!");
		return Redirect::back();
	}

	/**
	 *@return Delete permannently File in from Trash folder
	 *@param $id, string, File unique ID
	 */
	public function getDeleteFile($id) {
		if (!$id) {return view('errors.404-error');}
		$fileData = Docs::where(['user_id' => Auth::user()->id, 'doc_id' => $id, 'status' => '2'])->first();
		if (empty($fileData)) {return view('errors.404-error');}
		Docs::where(['user_id' => Auth::user()->id, 'doc_id' => $id])->update([
			'status' => '3',
			'updated_at' => date('Y-m-d H:i:s'),
		]);

		$directory = "docs/" . Auth::user()->token;
		$destinationPath = storage_path() . '/' . $directory;

		$path = $destinationPath . '/';
		$path .= $fileData->name;

		Storage::delete('media/profile/user-profile/' . $path);

		Session::flash('swal_type', 'success');
		Session::flash('swal_title', 'Success!');
		Session::flash('swal_text', "File deleted permanently!!");
		return Redirect::back();
	}

/**
 *@return Restore File in origin folder
 *@param $id, string, File unique ID
 */
	public function getRestoreFile($id) {
		if (!$id) {return view('errors.404-error');}
		$fileData = Docs::where(['user_id' => Auth::user()->id, 'doc_id' => $id, 'status' => '2'])->first();
		if (empty($fileData)) {return view('errors.404-error');}
		Docs::where(['user_id' => Auth::user()->id, 'doc_id' => $id])->update([
			'status' => '1',
			'updated_at' => date('Y-m-d H:i:s'),
		]);
		Session::flash('swal_type', 'success');
		Session::flash('swal_title', 'Success!');
		Session::flash('swal_text', "File restored to Origin!");
		return Redirect::back();
	}

/**
 *@return Restore Folder in origin folder
 *@param $id, string, Folder unique ID
 */
	public function getRestoreFolder($id) {
		if (!$id) {return view('errors.404-error');}
		$fileData = Folder::where(['user_id' => Auth::user()->id, 'folder_uid' => $id, 'status' => '2'])->first();
		if (empty($fileData)) {return view('errors.404-error');}
		Folder::where(['user_id' => Auth::user()->id, 'folder_uid' => $id])->update([
			'status' => '1',
			'updated_at' => date('Y-m-d H:i:s'),
		]);
		Session::flash('swal_type', 'success');
		Session::flash('swal_title', 'Success!');
		Session::flash('swal_text', "File restored to Origin!");
		return Redirect::back();
	}

	public function getSearch() {
		$key = Request::get('keyword');
		$allData = User::with(['folders' => function ($q) use ($key) {$q->where('name', $key)->orWhere('name', 'like', '%' . $key . '%')->where('status', '1');},
			'files' => function ($q) use ($key) {$q->where('original_name', $key)->orWhere('original_name', 'like', '%' . $key . '%')->where('status', '1');}])
			->where('id', Auth::user()->id)->get();
		Session::flash('keyword', $key);
		return view('search', compact('allData', 'key'));
	}

	public function postSearch() {
		// return
		$key = Request::get('search_key');
		$allData = User::with(['folders' => function ($q) use ($key) {$q->where('name', $key)->orWhere('name', 'like', '%' . $key . '%')->where('status', '1');},
			'files' => function ($q) use ($key) {$q->where('original_name', $key)->orWhere('original_name', 'like', '%' . $key . '%')->where('status', '1');}])
			->where('id', Auth::user()->id)->get();
		return redirect()->to('search?keyword=' . $key);
		// return view('search', compact('allData', 'key'));
	}

}