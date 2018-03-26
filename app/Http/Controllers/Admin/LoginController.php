<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Dao\SettingDao;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Lang;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends BaseAdminController
{

	use AuthenticatesUsers;

	// 登录后的跳转地址
	protected $redirectTo = '/admin';

	// 登录表单input名称
	protected $loginInputName = 'username';

	// 登录页面验证码标记
	protected $captchaAdminLogin = false;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->redirectTo = route('admin.index');

		$this->middleware('guest', ['except' => 'logout']);

		// 读取配置，是否启用验证码
		$setting = SettingDao::getSetting('setting');
		isset($setting['captchaadminlogin']) && $this->captchaAdminLogin = true;
	}

	/**
	 * 显示后台登录页面
	 *
	 * @author lxp 20170109
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function showLoginForm()
	{
		return view('admin.login', [
			'captchaadminlogin' => $this->captchaAdminLogin
		]);
	}

	/**
	 * 登出
	 *
	 * @author lxp 20170109
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function logout(Request $request)
	{
		$this->guard()->logout();

		$request->session()->flush();

		$request->session()->regenerate();

		return redirect(route('admin.login'));
	}

	/**
	 * 登录验证
	 *
	 * @author lxp 20170105
	 * @param $request
	 */
	protected function validateLogin(Request $request)
	{
		$rules = [
			$this->loginInputName => 'required',
			'password' => 'required',
		];
		// 添加验证码
		if ($this->captchaAdminLogin === true) {
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
	public function username()
	{
		if (is_mobile(request($this->loginInputName))) {
			return 'phone';
		} elseif (Validator::make(request()->all(), [$this->loginInputName => 'email'])->passes()) {
			return 'email';
		} else {
			return 'username';
		}
	}

	protected function credentials(Request $request)
	{
		return [
			$this->username() => $request->get($this->loginInputName),
			'password' => $request->get('password')
		];
	}

	/**
	 * 登录失败返回错误信息
	 *
	 * @author lxp 20170105
	 * @param Request $request
	 * @return $this
	 */
	protected function sendFailedLoginResponse(Request $request)
	{
		return redirect()->back()->withInput($request->only($this->loginInputName, 'remember'))->withErrors([
			$this->loginInputName => Lang::get('auth.failed'),
		]);
	}
}
