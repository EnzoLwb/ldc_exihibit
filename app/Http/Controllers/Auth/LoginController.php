<?php

namespace App\Http\Controllers\Auth;

use App\Dao\SettingDao;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Lang;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller {
	/*
	|--------------------------------------------------------------------------
	| Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles authenticating users for the application and
	| redirecting them to your home screen. The controller uses a trait
	| to conveniently provide its functionality to your applications.
	|
	*/

	use AuthenticatesUsers;

	// 登录后的跳转地址
	protected $redirectTo = '/';

	// 登录表单input名称
	protected $loginInputName = 'username';

	// 登录页面验证码标记
	protected $captchaLogin = false;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('guest', ['except' => 'logout']);

		// 读取配置，是否启用验证码
		$setting = SettingDao::getSetting('setting');
		isset($setting['captchalogin']) && $this->captchaLogin = true;
		view()->share('captchaLogin', $this->captchaLogin);
	}

	/**
	 * 登录验证
	 *
	 * @author lxp 20170105
	 * @param $request
	 */
	protected function validateLogin(Request $request) {
		$rules = [
			$this->loginInputName => 'required',
			'password' => 'required',
		];
		// 添加验证码
		if ($this->captchaLogin === true) {
			$rules['captcha'] = 'required|captcha';
		}

		$this->validate($request, $rules);
	}

	/**
	 * 判断用户登录类型（手机，邮箱，用户名）
	 *
	 * @author lxp 20170105
	 * @return string
	 */
	public function username() {
		if (is_mobile(request($this->loginInputName))) {
			return 'phone';
		} elseif (Validator::make(request()->all(), [$this->loginInputName => 'email'])->passes()) {
			return 'email';
		} else {
			return 'username';
		}
	}

	/**
	 * 登录失败返回错误信息
	 *
	 * @author lxp 20170105
	 * @param Request $request
	 * @return $this
	 */
	protected function sendFailedLoginResponse(Request $request) {
		return redirect()->back()->withInput($request->only($this->loginInputName, 'remember'))->withErrors([
			$this->loginInputName => Lang::get('auth.failed'),
		]);
	}

}
