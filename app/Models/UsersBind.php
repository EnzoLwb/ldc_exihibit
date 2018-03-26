<?php

namespace App\Models;

/**
 * 第三方用户绑定表
 *
 * @author lxp 20170915
 */
class UsersBind extends BaseMdl
{
	protected $primaryKey = 'bind_uid';
	public $timestamps = true;
}
