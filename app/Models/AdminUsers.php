<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * 管理员模型
 *
 * @author lxp 20170203
 */
class AdminUsers extends Authenticatable
{
	protected $primaryKey = 'uid';

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'salt',
		'remember_token',
	];

}
