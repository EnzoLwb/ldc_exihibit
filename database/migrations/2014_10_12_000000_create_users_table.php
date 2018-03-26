<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateUsersTable extends Migration
{
	private $tableName = 'users';
	private $tableComment = '用户表';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create($this->tableName, function (Blueprint $table) {
			$table->increments('uid')->unsigned()->comment('用户id');
			$table->string('username', 100)->comment('用户名')->unique();
			$table->string('nickname', 100)->comment('昵称')->nullable();
			$table->string('avatar', 100)->comment('头像')->nullable();
			$table->char('password', 32)->comment('密码');
			$table->string('email', 100)->comment('用户邮箱')->nullable();
			$table->string('phone', 60)->comment('用户手机号')->nullable();
			$table->timestamp('last_login')->comment('最后登录时间')->nullable();
			$table->string('lastloginip', 15)->comment('最后登录IP')->nullable();
			$table->char('salt', 6)->comment('密码盐');
			$table->rememberToken();
			$table->char('api_token', 32)->comment('APP token')->nullable();
			$table->char('plat', 3)->comment('注册平台来源，i：IOS，a：安卓，w：Web，t：触摸屏或手机')->nullable();
			$table->char('deviceno', 13)->comment('设备号')->nullable();
			$table->timestamps();

			if (env('DB_CONNECTION') == 'oracle') {
				$table->comment = $this->tableComment;
			}
		});

		if (env('DB_CONNECTION') == 'mysql') {
			DB::statement("ALTER TABLE `" . DB::getTablePrefix() . $this->tableName . "` comment '{$this->tableComment}'");
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists($this->tableName);
		if (env('DB_CONNECTION') == 'oracle') {
			$sequence = DB::getSequence();
			$sequence->drop(strtoupper($this->tableName . '_uid_SEQ'));
		}
	}
}
