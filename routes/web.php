<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
Route::group(['middleware' => 'web'], function () {

	Route::get('/', function () {
		return view('guest.login');
		// return view('welcome');

	});

	// Return view login page
	Route::get('login', ['as' => 'login', 'uses' => 'GuestController@getLogin']);
	// handle Login request and redirect to dashboard
	Route::post('login', ['as' => 'login.post', 'uses' => 'GuestController@postLogin']);

	Route::get('signup', ['as' => 'signup', 'uses' => 'GuestController@getSignup']);
	// post the user new account registartion details
	Route::post('signup', ['as' => 'signup.post', 'uses' => 'GuestController@postSignup']);
	// redirect to success page after signup
});

Route::group(['middleware' => ['web', 'auth']], function () {

	Route::get('home', ['as' => 'home', 'uses' => 'HomeController@getHome']);
	// Return view Logout page
	Route::get('logout', ['as' => 'logout', 'uses' => 'GuestController@getLogut']);

	Route::post('create/folder', ['as' => 'create.folder', 'uses' => 'HomeController@postAddFolder']);

	Route::get('trash', ['as' => 'trash', 'uses' => 'HomeController@getTrash']);

	Route::get('open/folder/source/{id}', ['as' => 'folder.open', 'uses' => 'HomeController@getOpenFolder']);

	Route::get('trash/folder/source/{id}', ['as' => 'folder.trash', 'uses' => 'HomeController@getTrashFolder']);

	Route::get('delete/folder/source/{id}', ['as' => 'folder.delete', 'uses' => 'HomeController@getDeleteFolder']);

	Route::get('restore/folder/source/{id}', ['as' => 'folder.restore', 'uses' => 'HomeController@getRestoreFolder']);

	Route::post('upload/files', ['as' => 'upload.files', 'uses' => 'HomeController@postUploadFiles']);

	Route::get('view/file/source/{id}', ['as' => 'file.view', 'uses' => 'HomeController@getViewFile']);

	Route::get('download/file/source/{id}', ['as' => 'file.download', 'uses' => 'HomeController@getDownloadFile']);

	Route::get('trash/file/source/{id}', ['as' => 'file.trash', 'uses' => 'HomeController@getTrashFile']);

	Route::get('delete/file/source/{id}', ['as' => 'file.delete', 'uses' => 'HomeController@getDeleteFile']);

	Route::get('restore/file/source/{id}', ['as' => 'file.restore', 'uses' => 'HomeController@getRestoreFile']);

	Route::get('search', ['as' => 'search', 'uses' => 'HomeController@getSearch']);
	Route::post('search', ['as' => 'search', 'uses' => 'HomeController@postSearch']);

});