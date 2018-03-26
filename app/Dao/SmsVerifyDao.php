<?php

namespace App\Dao;

use App\Exceptions\ApiErrorException;
use App\Models\SmsVerify;

/**
 * 用户业务模型
 *
 * @author lxp 20170826
 */
class SmsVerifyDao extends SmsVerify
{

	/**
	 * 验证码检查
	 *
	 * @author lxp 20170831
	 * @param string $phone 手机号
	 * @param string $smscode 验证码
	 * @return bool
	 * @throws ApiErrorException
	 */
	public static function code_check($phone, $smscode)
	{
		$sms = SmsVerify::where('mobile', $phone)->where('status', 1)->orderBy('created_at', 'DESC')->first();
		if (!$sms || $sms->smscode != $smscode) {
			throw new ApiErrorException('验证码错误或已验证');
		} else {
			// 可针对验证码生成时间再判断
			if ((date('U') - strtotime($sms->created_at)) > 60 * 15) {
				$sms->status = 3;
				$sms->save();
				throw new ApiErrorException('验证码已过期，请重试。');
			}

			// 将该手机号之前的验证码都置为失效
			SmsVerify::where('mobile', $phone)->where('status', 1)->update(['status' => 3]);
			// 将验证码状态变为已验证
			$sms->status = 2;
			$sms->save();
			return true;
		}
	}

}
