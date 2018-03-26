<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\UrlGenerator;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	// 每页显示记录条数
	const PERPAGE = 15;

	public function __construct() { }

	/**
	 * 操作成功提示
	 *
	 * @author lxp 20170204
	 * @param string $redirect 需要跳转的地址
	 * @param string $msg 提示消息，语言文件key
	 * @param bool $iframe_jump 父类窗口是否跳转$redirect，用于iframe弹窗
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	protected function success($redirect = '', $msg = '', $iframe_jump = false)
	{
		if (!$redirect) {
			$redirect = app(UrlGenerator::class)->previous();
		}

		if (!$msg) {
			$msg = trans("msg.s_operate");
		} else {
			$msg = trans("msg.{$msg}") == "msg.{$msg}" ? $msg : trans("msg.{$msg}");
		}

		$returnData = [
			'status' => true,
			'msg' => $msg,
			'url' => $redirect,
			'iframe_jump' => $iframe_jump
		];

		if (request()->ajax() || request('ajax') == 1) {
			return response()->json($returnData);
		} else {
			return view('showmsg', $returnData);
		}
	}

	/**
	 * 操作成功并返回数据
	 *
	 * @author lxp 20170302
	 * @param array $data
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function successData($data = [])
	{
		$returnData = [
			'status' => true,
			'data' => $data
		];

		return response()->json($returnData);
	}

	/**
	 * 操作失败提示，无自动跳转
	 *
	 * @author lxp 20170204
	 * @param string $msg 提示消息，语言文件key
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	protected function error($msg = '')
	{
		if (!$msg) {
			$msg = trans("msg.e_operate");
		} else {
			$msg = trans("msg.{$msg}") == "msg.{$msg}" ? $msg : trans("msg.{$msg}");
		}

		$returnData = [
			'status' => false,
			'msg' => $msg,
		];

		if (request()->ajax() || request('ajax') == 1) {
			return response()->json($returnData);
		} else {
			return view('showmsg', $returnData);
		}
	}
}
