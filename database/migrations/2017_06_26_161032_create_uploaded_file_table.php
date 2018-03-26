<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateUploadedFileTable extends Migration
{
	private $tableName = 'uploaded_file';
	private $tableComment = '上传文件总表';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create($this->tableName, function (Blueprint $table) {
			$table->increments('file_id');
			$table->string('file_mime', 255)->comment('文件类型')->nullable();
			$table->integer('file_size')->comment('文件大小')->default(0);
			$table->string('file_name', 255)->comment('文件名')->nullable();
			$table->string('file_oldname', 255)->comment('原文件名')->nullable();
			$table->string('file_path', 255)->comment('文件路径')->nullable();
			$table->char('file_md5', 32)->comment('文件MD5验证')->nullable();
			$table->tinyInteger('file_status')->comment('文件状态，0未验证，1已验证（OSS或本地存储有文件）')->nullable()->default(0);
			$table->integer('uid', false, true)->comment('上传者id')->default(0);
			$table->integer('type_id')->comment('附件所属类型id')->default(0);
			$table->integer('item_id')->comment('附件所属类型的条目id')->default(0);
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
			$sequence->drop(strtoupper($this->tableName . '_file_id_SEQ'));
		}
	}
}
