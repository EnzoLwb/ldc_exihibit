<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateUploadedTypeTable extends Migration
{
	private $tableName = 'uploaded_type';
	private $tableComment = '附件类型';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create($this->tableName, function (Blueprint $table) {
			$table->increments('type_id');
			$table->string('type_key', 60)->comment('类型键值，用于初始化常量，大写')->nullable();
			$table->string('path', 255)->comment('附件存储相对路径')->nullable();
			$table->string('desc', 255)->comment('说明')->nullable();
			$table->string('allow_type', 255)->comment('允许上传的文件类型')->nullable();
			$table->integer('allow_size', false, true)->comment('允许上传的单个文件大小，0为不限制')->default(0)->nullable();
			$table->integer('allow_num', false, true)->comment('允许上传的文件个数')->default(1)->nullable();
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
			$sequence->drop(strtoupper($this->tableName . '_type_id_SEQ'));
		}
	}
}

