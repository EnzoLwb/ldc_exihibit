<?php

namespace App\Notifications;

use App\Channels\IpyyChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * 忘记密码邮件通知，已使用队列
 *
 * @author lxp 20170304
 * @package App\Notifications
 */
class ForgotPassword extends Notification implements ShouldQueue
{
	use Queueable;

	public $token;

	/**
	 * ForgotPassword constructor.
	 *
	 * @param $token
	 */
	public function __construct($token)
	{
		$this->token = $token;
	}

	/**
	 * 返回通知频道
	 *
	 * @param  mixed $notifiable
	 * @return array
	 */
	public function via($notifiable)
	{
		$via = ['mail'];
		// 发送短信通知
		array_push($via, IpyyChannel::class);

		return $via;
	}

	/**
	 * 邮件通知内容
	 *
	 * @param  mixed $notifiable
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail($notifiable)
	{
		return (new MailMessage)
			->subject('重置密码 - ' . config('app.name'))
			->line('您收到这封电子邮件是因为我们收到了您帐户的密码重设要求。')
			->action('重置密码', url('password/reset', $this->token))
			->line('如果您未请求重置密码，则无需进一步操作。');
	}

	/**
	 * ipyy短信内容
	 *
	 * @author lxp 20170304
	 * @param $notifiable
	 * @return string
	 */
	public function toIpyy($notifiable)
	{
		return '您正在要求重设密码，如果您未请求重置密码，请忽略此短信。';
	}

}
