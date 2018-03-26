<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateArticleTable extends Migration
{
	private $tableName = 'article';
	private $tableComment = '文章表';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create($this->tableName, function (Blueprint $table) {
			$table->increments('article_id');
			$table->integer('uid', false, true)->comment('作者id');
			$table->integer('cate_id', false, true)->comment('分类id')->default(0);
			$table->string('title', 100)->comment('文章标题');
			$table->string('sub_title', 50)->comment('文章短标题')->nullable();
			$table->string('des', 255)->comment('文章简介')->nullable();
			$table->mediumText('content')->comment('文章内容')->nullable();
			$table->string('default_img', 255)->comment('文章头图')->nullable();
			$table->string('source', 100)->comment('来源')->nullable();
			$table->string('keywords', 255)->comment('关键字')->nullable();
			$table->tinyInteger('is_show', false, true)->comment('是否显示，1显示，0不显示')->default(0);
			$table->tinyInteger('is_top', false, true)->comment('是否置顶，1置顶，0不置顶')->default(0);
			$table->tinyInteger('is_recommend', false, true)->comment('是否推荐，1推荐，0不推荐')->default(0);
			$table->tinyInteger('is_comment', false, true)->comment('是否允许评论，1允许，0不允许')->default(1);
			$table->integer('views', false, true)->comment('查看数')->default(0);
			$table->integer('comments', false, true)->comment('评论数')->default(0);
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
			$sequence->drop(strtoupper($this->tableName . '_article_id_SEQ'));
		}
	}
}


