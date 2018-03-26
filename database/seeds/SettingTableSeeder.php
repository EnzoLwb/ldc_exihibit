<?php

use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// 默认设置
		\App\Dao\SettingDao::setSetting('setting', [
			'system_name' => '后台管理系统',
			'logo' => '',
			'system_version' => '',
			'captchaadminlogin' => 1
		]);
	}
}
