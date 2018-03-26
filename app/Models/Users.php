<?php

namespace App\Models;

use App\Notifications\ForgotPassword AS ForgotPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * 用户模型
 *
 * @author lxp 20170105
 */
class Users extends Authenticatable
{
	use Notifiable;

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
		'api_token'
	];

	/**
	 * 覆写忘记密码发送通知
	 *
	 * @author lxp 20170304
	 * @param string $token
	 */
	public function sendPasswordResetNotification($token)
	{
		$this->notify(new ForgotPasswordNotification($token));
	}

	/**
	 * 返回发送ipyy短信需要的手机号
	 *
	 * @author lxp 20170304
	 * @return string
	 */
	public function routeNotificationForIpyy()
	{
		return $this->phone;
	}
}
