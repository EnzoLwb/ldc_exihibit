<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateSmsVerifyTable extends Migration
{

	private $tableName = 'sms_verify';
	private $tableComment = '短信验证表';
	private $primaryKey = 'id';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create($this->tableName, function (Blueprint $table) {
			$table->increments($this->primaryKey);
			$table->string('mobile', 20)->comment('手机号');
			$table->char('smscode', 32)->comment('验证码');
			$table->string('ip', 15)->comment('最后登录IP')->nullable();
			$table->char('plat', 3)->comment('注册平台来源，i：IOS，a：安卓，w：Web，t：触摸屏或手机')->nullable();
			$table->tinyInteger('status', false, true)->comment('状态，1：正常，2：已验证，3：失效')->default(1);
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
