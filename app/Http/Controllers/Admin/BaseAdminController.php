<?php

namespace App\Http\Controllers\Admin;

use App\Dao\MenuDao;
use App\Dao\SettingDao;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * 管理后台控制器基类
 *
 * @author lxp 20170110
 * @package App\Http\Controllers\Admin
 */
class BaseAdminController extends Controller
{

	// 每页显示记录条数
	const PERPAGE = 15;

	public function __construct()
	{
		parent::__construct();

		// 取出系统基本信息
		$setting = SettingDao::getSetting('setting');
		view()->share('system_name', isset($setting['system_name']) ? $setting['system_name'] : '');
		view()->share('system_logo', isset($setting['logo']) && $setting['logo'] ? $setting['logo'] : 'img/logo.png');
		view()->share('system_version', isset($setting['system_version']) ? '' . $setting['system_version'] : '');

		// 处理左侧菜单
		view()->share('menulist', MenuDao::get_admin_menu());

		// 设置默认Guard
		Auth::setDefaultDriver('admin');
	}

}
