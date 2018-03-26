<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		// 强制更新静态文件的随机码
		view()->share('_static_update', '?1');

		// 添加自定义手机号验证 lxp 20170105
		Validator::extend('mobile', function ($attribute, $value, $parameters) {
			return is_mobile($value);
		});
		// 添加自定义验证码验证 lxp 20170105
		Validator::extend('captcha', function ($attribute, $value, $parameters) {
			return app('captcha')->check($value);
		});
		// 添加自定义身份证验证 lxp 20170819
		Validator::extend('idcard', function ($attribute, $value, $parameters) {
			return is_idcard($value, true);
		});
		// 添加自定义MAC地址验证 lxp 20171012
		Validator::extend('macaddress', function ($attribute, $value, $parameters) {
			return preg_match('/^([A-Fa-f0-9]{2}(-|:)){5}[A-Fa-f0-9]{2}$/', $value) ? true : false;
		});

	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}
}
