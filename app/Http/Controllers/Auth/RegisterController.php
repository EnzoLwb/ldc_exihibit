<?php

namespace App\Http\Controllers\Auth;

use App\Dao\SettingDao;
use App\Models\Users;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;

class RegisterController extends Controller {
	/*
	|--------------------------------------------------------------------------
	| Register Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users as well as their
	| validation and creation. By default this controller uses a trait to
	| provide this functionality without requiring any additional code.
	|
	*/

	use RegistersUsers;

	/**
	 * Where to redirect users after registration.
	 *
	 * @var string
	 */
	protected $redirectTo = '/';

	// 注册页面验证码标记
	protected $captchaRegister = false;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('guest');

		// 读取配置，是否启用验证码
		$setting = SettingDao::getSetting('setting');
		isset($setting['captcharegister']) && $this->captchaRegister = true;
		view()->share('captchaRegister', $this->captchaRegister);
	}

	/**
	 * 用户注册验证
	 *
	 * @author lxp 20160616
	 * @param  array $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data) {
		$rules = [
			'username' => 'required|min:6|max:20|unique:users',
			'email' => 'required|email|unique:users|max:255',
			'phone' => 'required|mobile|unique:users',
			'password' => 'required|min:6|confirmed',
		];
		// 添加验证码
		if ($this->captchaRegister === true) {
			$rules['captcha'] = 'required|captcha';
		}

		return Validator::make($data, $rules);
	}

	/**
	 * 创建用户
	 *
	 * @author lxp 20160616
	 * @param  array $data
	 * @return Users
	 */
	protected function create(array $data) {
		// 处理密码
		$salt = Str::random(6);
		$password = get_password($data['password'], $salt);

		// 添加用户
		$usersMod = new Users();
		$usersMod->username = $data['username'];
		$usersMod->email = $data['email'];
		$usersMod->phone = $data['phone'];
		$usersMod->password = $password;
		$usersMod->salt = $salt;
		$usersMod->lastloginip = app('request')->ip();
		$usersMod->save();
		return $usersMod;
	}
}
