<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateCommentTable extends Migration
{
	private $tableName = 'acomment';
	private $tableComment = '评论表';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create($this->tableName, function (Blueprint $table) {
			$table->increments('comment_id');
			$table->integer('article_id', false, true)->comment('文章id');
			$table->integer('uid', false, true)->comment('作者id');
			$table->string('uname', 100)->comment('用户名')->nullable();
			$table->timestamp('add_time')->comment('创建时间')->nullable()->default(null);
			$table->tinyInteger('status', false, true)->comment('状态，1正常，2待审核')->default(1);
			$table->text('comment')->comment('评论内容')->nullable();
			$table->integer('parent_cid', false, true)->comment('父级评论id')->default(0);
			$table->integer('zan', false, true)->comment('赞数')->default(0);

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
			$sequence->drop(strtoupper($this->tableName . '_comment_id_SEQ'));
		}
	}
}

