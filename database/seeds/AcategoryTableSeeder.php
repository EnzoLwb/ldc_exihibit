<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcategoryTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('acategory')->insert([
			'cate_name' => '内置文章',
			'is_show' => 0,
			'sort_order' => '1'
		]);
		DB::table('acategory')->insert([
			'cate_name' => '资讯',
			'sort_order' => '2'
		]);
	}
}