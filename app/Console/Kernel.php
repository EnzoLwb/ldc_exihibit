<?php

namespace App\Console;

use App\Console\Commands\ApiDoc;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
	/**
	 * 自定义命令
	 *
	 * @var array
	 */
	protected $commands = [
		ApiDoc::class
	];

	/**
	 * 自定义计划任务
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		// $schedule->command('inspire')
		//          ->hourly();
	}

	/**
	 * Register the commands for the application.
	 *
	 * @return void
	 */
	protected function commands()
	{
		$this->load(__DIR__ . '/Commands');

		require base_path('routes/console.php');
	}
}
