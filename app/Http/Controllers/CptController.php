<?php
namespace App\Http\Controllers;

use Response;

/**
 * 验证码控制器
 *
 * @package App\Http\Controllers
 */
class CptController extends Controller {

	/**
	 * 生成验证码
	 *
	 * @author lxp 20170105
	 * @return mixed
	 */
	public function show() {
		return app('captcha')->show();
	}

	/**
	 * 检查验证码
	 *
	 * @author lxp 20170105
	 * @return JsonResponse
	 */
	public function check() {
		return Response::json(app('captcha')->check(request('captcha')));
	}
}
