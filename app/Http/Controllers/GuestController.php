<?php

namespace App\Http\Controllers;
// use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Rules;
use App\Models\User;
use Auth;
use Hash;
use Redirect;
use Request;
use Response;
use Session;
use Validator;
use View;

class GuestController extends Controller {

/**
 *@return Returns the User Signin page
 */
	public function getSignup() {
		if (Auth::check()) {
			return Redirect::to('home');
		} else {
			return view('guest.signup');
		}
	}

/**
 *@return Returns the verification code
 */
	protected function _getVerificationCode() {
		// return md5(uniqid(rand(), true));
		return bin2hex(openssl_random_pseudo_bytes(10));
	}

	/**
	 * Handle a registration request for the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postSignup() {
		$datetime = date("Y-m-d G:i:s");

		$validator = Validator::make(Request::all(), Rules::$signup);
		if ($validator->fails()) {
			return Redirect::back()->withInput()->withErrors($validator);
		}

		$name = Request::get('name');
		$email = Request::get('email');
		$password = Request::get('password');
		$password = Hash::make($password);

		// Generate Random Email Verification Code.
		$verificationCode = $this->_getVerificationCode();

		// ================= Save User Details in users table =====================
		$user = new User;
		$user->name = $name;
		$user->email = Request::get('email');
		$user->password = $password;
		$user->token = $verificationCode;
		$user->status = '1'; // 1 = Active
		$user->created_at = $datetime;
		$user->updated_at = $datetime;
		$user->save();

		$userID = $user->id;

		Session::flash('flash_success', 'Your account is created successfully, Please Login with your credentials to continue!!');
		return Redirect::to('login');

	}

/**
 *@return View page of user login
 */
	public function getLogin() {
		if (Auth::check()) {
			return Redirect::to('home');
		}
		return View::make('guest.login');
	}

/**
 * Handle a login request to the application.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
	public function postLogin() {
		$rules = [
			'email' => 'required|email',
			'password' => 'required|min:6',
		];
		$email = Request::get('email');
		$password = Request::get('password');
		$remember = Request::get('remember', false);
		$validator = Validator::make(Request::all(), $rules);
		if ($validator->fails()) {
			return Redirect::back()->withInput()->withErrors($validator);
		}

		$credentials = ['email' => $email, 'password' => $password];
		// If you only want to validate and not log the user in, you can pass a third option. The default for this third option is true. False will only Validate.
		$attempt = Auth::attempt($credentials, Request::has('remember'), false);

		if ($attempt === false) {
			return Redirect::back()->withInput()->with(['flash_error' => 'Login Credentials incorrect. Please enter again.']);
		}
		return redirect()->to('home');

	}

	public function getLogut() {
		Auth::logout();
		Session::flush();
		return redirect('/');
	}

}