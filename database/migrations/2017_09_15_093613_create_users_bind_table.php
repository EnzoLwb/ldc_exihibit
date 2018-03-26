<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateUsersBindTable extends Migration
{
	private $tableName = 'users_bind';
	private $tableComment = '第三方登录绑定表';
	private $primaryKey = 'bind_uid';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create($this->tableName, function (Blueprint $table) {
			$table->increments($this->primaryKey);
			$table->integer('uid', false, true)->comment('用户id');
			$table->string('openid', 50)->comment('第三方id');
			$table->string('b_from', 10)->comment('来源，wx微信，wb微博，qq');
			$table->string('b_nickname', 100)->comment('第三方昵称');
			$table->string('b_avatar')->comment('第三方头像');
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
			$sequence->drop(strtoupper($this->tableName . '_' . $this->primaryKey . '_SEQ'));
		}
	}
}
