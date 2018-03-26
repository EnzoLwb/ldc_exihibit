<?php

namespace App\Models;

use App\Notifications\SmsVerification;
use Illuminate\Notifications\Notifiable;

/**
 * 短信验证模型
 *
 * @author lxp 20170731
 */
class SmsVerify extends BaseMdl
{
	use Notifiable;

	protected $primaryKey = 'id';
	public $timestamps = true;

	/**
	 * 发送短信验证通知
	 *
	 * @author lxp 20170811
	 */
	public function sendSmsNotification()
	{
		$this->notify(new SmsVerification());
	}

	/**
	 * 返回发送短信需要的手机号
	 *
	 * @author lxp
	 * @return mixed
	 */
	public function mobileForHnsbSms()
	{
		return $this->mobile;
	}

	/**
	 * getSmscodeAttribute
	 *
	 * @author lxp
	 * @param $value
	 * @return string
	 */
	public function getSmscodeAttribute($value)
	{
		return trim($value);
	}
}
