<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Dao\SettingDao;
use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Support\Facades\Cache;

/**
 * 网站配置控制器
 *
 * @package App\Http\Controllers\Admin\Setting
 */
class BaseSettingController extends BaseAdminController
{

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * 设置页面
	 *
	 * @author lxp 20170206
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
	 */
	public function index()
	{
		if (request()->isMethod('post')) {
			$request = request()->all();
			unset($request['_token']);
			SettingDao::setSetting('setting', $request);

			return $this->success('', 's_store');
		} else {
			return view('admin.setting.setting', [
				'setting' => SettingDao::getSetting('setting')
			]);
		}
	}

	/**
	 * 更新缓存
	 *
	 * @author lxp 20160702
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function clearcache()
	{
		// 网站配置
		Cache::forget('setting:setting');
		// 附件上传类型
		Cache::forget('uploadedtype');

		return $this->success();
	}
}