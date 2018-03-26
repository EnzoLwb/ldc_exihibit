<?php

namespace App\Dao;

use App\Models\Users;

/**
 * 用户业务模型
 *
 * @author lxp 20170826
 */
class UsersDao extends Users
{

	/**
	 * 生成随机昵称
	 *
	 * @author lxp 20170909
	 * @param string $nickname_base
	 * @return string
	 */
	public static function get_nickname($nickname_base = '')
	{
		$str = mt_rand(10000000, 99999999);
		$md5str = md5($str . date('YmdHis'));
		if ($nickname_base) {
			$nickname = $nickname_base . substr($md5str, 10, 5);
		} else {
			$nickname = 'U' . substr($md5str, 10, 10);
		}
		if (Users::where('nickname', $nickname)->count() > 0) {
			return self::get_nickname($nickname_base);
		}
		return $nickname;
	}
}
