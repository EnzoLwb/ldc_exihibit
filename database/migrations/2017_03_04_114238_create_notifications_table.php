<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateNotificationsTable extends Migration
{
	private $tableName = 'notifications';
	private $tableComment = '通知表';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create($this->tableName, function (Blueprint $table) {
			if (env('DB_CONNECTION') == 'oracle') {
				$table->char('id', 36)->primary();
			} else {
				$table->uuid('id')->primary();
			}
			$table->string('type');
			$table->morphs('notifiable');
			$table->text('data')->nullable();
			$table->timestamp('read_at')->nullable();
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
	}
}
