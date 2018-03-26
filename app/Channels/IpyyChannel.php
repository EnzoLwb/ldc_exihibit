<?php

namespace App\Channels;

use GuzzleHttp\Client;
use Illuminate\Notifications\Notification;

/**
 * 华信短信平台短信通知
 *
 * @author lxp 20170304
 * @package App\Channels
 */
class IpyyChannel
{
	/**
	 * 发送给定通知。
	 *
	 * @param  mixed $notifiable
	 * @param  \Illuminate\Notifications\Notification $notification
	 * @return void
	 */
	public function send($notifiable, Notification $notification)
	{
		// 取得短信内容
		$message = $notification->toIpyy($notifiable);
		// 取得手机号
		$mobile = $notifiable->routeNotificationForIpyy();

		if (is_mobile($mobile)) {
			self::sendSms($message, $mobile);
		}
	}

	/**
	 * 发送短信
	 *
	 * @author lxp 20170304
	 * @param string $content 短信内容
	 * @param string $mobile 手机号
	 * @return boolean
	 */
	public static function sendSms($content, $mobile)
	{
		if (!is_mobile($mobile)) {
			return false;
		}

		$client = new Client([
			'base_uri' => 'http://sh2.ipyy.com',
			'connect_timeout' => 2,
			'timeout' => 2
		]);
		$request = $client->request('GET', 'sms.aspx', [
			'query' => [
				'action' => 'send',
				'userid' => '',
				'account' => env('SMS_ACCOUNT', ''),
				'password' => env('SMS_PWD', ''),
				'mobile' => $mobile,
				'content' => $content,
				'sendTime' => '',
				'extno' => ''
			]
		]);

		$result = simplexml_load_string($request->getBody());
		if (strtolower($result->returnstatus) == 'success') {
			return true;
		} else {
			$logObj = app('logext');
			$logObj->init('sms_error');
			$logObj->logbuffer('phone_no', $mobile);
			$logObj->logbuffer('content', $content);
			$logObj->logbuffer('message', $result->message);
			$logObj->logend();
			return false;
		}
	}

}