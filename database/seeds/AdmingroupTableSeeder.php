<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdmingroupTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('admin_group')->insert([
			'groupname' => 'HD管理员',
			'privs' => 'all'
		]);
	}
}
