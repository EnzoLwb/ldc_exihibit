<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class UserLogin
{
	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * handle
	 *
	 * @author lxp 20170615
	 * @param Login $event
	 */
	public function handle(Login $event)
	{
		// 可区分前后台
		//		switch (Auth::getDefaultDriver()){
		//			case 'web':
		//				break;
		//			case 'admin':
		//				break;
		//		}

		// 更新最后登录时间和IP
		$event->user->last_login = date('Y-m-d H:i:s');
		$event->user->lastloginip = app('request')->ip();
		$event->user->save();
	}
}
