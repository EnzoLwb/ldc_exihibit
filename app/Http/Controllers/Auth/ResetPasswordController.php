<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Password Reset Controller
	|--------------------------------------------------------------------------
	|
	| This controller is responsible for handling password reset requests
	| and uses a simple trait to include this behavior. You're free to
	| explore this trait and override any methods you wish to tweak.
	|
	*/

	use ResetsPasswords;

	/**
	 * Where to redirect users after resetting their password.
	 *
	 * @var string
	 */
	protected $redirectTo = '/';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * 覆写重置密码
	 *
	 * @author lxp 20170303
	 * @param $user
	 * @param $password
	 */
	protected function resetPassword($user, $password)
	{
		// 处理密码
		$salt = Str::random(6);
		$password = get_password($password, $salt);

		$user->forceFill([
			'password' => $password,
			'salt' => $salt,
			'remember_token' => Str::random(60),
			'api_token' => get_api_token($user->uid)
		])->save();

		$this->guard()->login($user);
	}
}
