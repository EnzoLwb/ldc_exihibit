<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateMultiuploadPartTable extends Migration
{
	private $tableName = 'mulitupload_part';
	private $tableComment = '分片上传文件碎片表';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create($this->tableName, function (Blueprint $table) {
			$table->increments('id');
			$table->integer('fid');
			$table->string('name', 255);
			$table->integer('chunk');
			$table->string('md5');
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
			$sequence->drop(strtoupper($this->tableName . '_id_SEQ'));
		}
	}
}
