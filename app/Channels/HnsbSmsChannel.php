<?php

namespace App\Channels;

use GuzzleHttp\Client;
use Illuminate\Notifications\Notification;

/**
 * 湖南省博短信平台短信通知
 *
 * @author lxp 20170811
 * @package App\Channels
 */
class HnsbSmsChannel
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
		$message = $notification->toSms($notifiable);
		// 取得手机号
		$mobile = $notifiable->mobileForHnsbSms();

		if (is_mobile($mobile)) {
			self::sendSms($message, $mobile);
		}
	}

	/**
	 * 发送短信
	 *
	 * @author lxp 20170811
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
			'base_uri' => 'http://42.121.98.132:8888',
			'connect_timeout' => 2,
			'timeout' => 2
		]);
		$request = $client->request('POST', 'sms.aspx', [
			'query' => [
				'action' => 'send',
				'userid' => env('SMS_USERID', ''),
				'account' => env('SMS_ACCOUNT', ''),
				'password' => env('SMS_PWD', ''),
				'mobile' => $mobile,
				'content' => $content,
				'sendTime' => '',
				'extno' => ''
			]
		]);

		$result = simplexml_load_string($request->getBody());

		//		$logObj = app('logext');
		//		$logObj->init('sms');
		//		$logObj->logbuffer('result', json_encode($result));
		//		$logObj->logend();

		if (strtolower($result->returnstatus) == 'success') {
			return true;
		} else {
			$logObj = app('logext');
			$logObj->init('sms_error');
			$logObj->logbuffer('phone_no', $mobile);
			$logObj->logbuffer('content', $content);
			$logObj->logbuffer('message', $result->message);
			$logObj->logbuffer('result', json_encode($result));
			$logObj->logend();
			return false;
		}
	}

}