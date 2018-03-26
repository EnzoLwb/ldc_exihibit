<?php

namespace App\Dao;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

/**
 * 网站配置业务模型
 *
 * @author lxp 20160627
 */
class SettingDao extends Setting
{

	/**
	 * 取得配置项的值
	 *
	 * @author lxp 20160702
	 * @param string $skey
	 * @return mixed
	 */
	public static function getSetting($skey)
	{
		//		return Cache::rememberForever('setting:' . $skey, function () use ($skey) {
		$setting = Setting::where('skey', $skey)->first();
		if (!is_null($setting)) {
			return unserialize($setting->svalue);
		} else {
			return '';
		}
		//		});
	}

	/**
	 * 设置配置项
	 *
	 * @author lxp 20160702
	 * @param string $skey
	 * @param mixed $svalue 为null时则删除该键
	 */
	public static function setSetting($skey, $svalue)
	{
		//		if ($svalue == null) {
		//			Setting::destroy($skey);
		//			Cache::forget($skey);
		//		} else {
		$setting = Setting::where('skey', $skey)->first();
		if (!$setting) {
			$setting = new Setting();
			$setting->skey = $skey;
		}
		$setting->svalue = serialize($svalue);
		$setting->save();
		//			Cache::forever('setting:' . $skey, $svalue);
		//		}
	}
}
