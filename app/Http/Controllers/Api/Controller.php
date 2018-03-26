<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiErrorException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
	const PER_PAGE = 20;

	/**
	 *
	 * @api {GET} / 1. 通用说明
	 * @apiName 通用说明
	 * @apiGroup Base
	 * @apiVersion 1.0.0
	 * @apiParam {string} p 请求平台，i：IOS，a：安卓，w：Web，t：触屏或手机，d：导览机，ter：终端、票机等其他设备
	 * @apiParam {int} [language=1] 语种，1中文，2英语，3日语，4韩语，5法语，6西班牙语，7德语，8俄语，9意大利
	 * @apiParam {int} [v] 版本号，例：v=1
	 * @apiSuccess {int} status 状态码1
	 * @apiSuccess {object} data 数据
	 * @apiSuccess {string} msg 文字信息
	 * @apiSuccessExample {json} 返回值
	 * {"status":1,"data":{},"msg":""}
	 * @apiError {int} status 0: 通用错误<br/>404: 空方法调用<br/>405: api_token验证失败
	 * @apiError {string} msg 错误信息
	 * @apiErrorExample {json} 错误返回值
	 * {"status":0,"msg":""}
	 */

	/**
	 * @api {GET} / 2. 缩略图请求说明
	 * @apiName 缩略图请求说明
	 * @apiGroup Base
	 * @apiVersion 1.0.0
	 * @apiParam {string} readme 图片URL生成规则：<br/>域名/thumbimg/md5图片路径的第一个字符/md5图片路径的第四个字符/宽度/高度/剪裁类型/base64图片路径.auto.jpg<br/><br/>例如：图片路径为 /uploadfiles/test/bn1.png<br/>生成的缩略图链接为：<br/>http://192.168.10.158:8110/thumbimg/6/8/500/300/33/L3VwbG9hZGZpbGVzL3Rlc3QvYm4xLnBuZw==.auto.png <br/><br/>图片剪裁类型：<br/>31：按缩放比小的一边等比缩放<br/>32：按比例缩放后填充<br/>33：等比缩放后居中剪切（推荐）<br/>34：左上剪切<br/>35：右下剪切<br/>36：固定尺寸，图片可能变形<br/>
	 */

	protected function _init()
	{
		// 设置默认Guard
		Auth::setDefaultDriver('api');
		// 设置当前语言包
		$language = config('language');
		if (request('language') && isset($language[request('language')])) {
			app()->setLocale($language[request('language')]['dir']);
		} else {
			app()->setLocale('zh-cn');
		}

		$platformArray = config('platform');
		if (!request('p') || (is_array($platformArray) && !isset($platformArray[request('p')]))) {
			throw new ApiErrorException('Error Plat');
		}

	}

	/**
	 * 通用验证方法
	 *
	 * @author lxp 20170814
	 * @param array $rules 验证规则
	 * @throws ApiErrorException
	 */
	protected function validate($rules)
	{
		// 验证输入数据
		$validator = Validator::make(request()->all(), $rules);
		// 返回错误提示
		if ($validator->fails()) {
			$errors = $validator->errors()->all();
			throw new ApiErrorException(current($errors));
		}
	}

}
