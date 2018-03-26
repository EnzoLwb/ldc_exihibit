<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateAcategoryTable extends Migration
{
	private $tableName = 'acategory';
	private $tableComment = '文章分类表';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create($this->tableName, function (Blueprint $table) {
			$table->increments('cate_id');
			$table->string('cate_name', 100)->comment('分类名');
			$table->integer('parent_id', false, true)->comment('父分类id')->default(0);
			$table->tinyInteger('sort_order', false, true)->comment('分类显示顺序')->default(255);
			$table->tinyInteger('is_show', false, true)->comment('是否显示该分类，1显示，0不显示')->default(1);
			$table->tinyInteger('layer', false, true)->comment('分类层级')->default(0);
			$table->string('icon', 255)->comment('分类图标地址')->nullable();

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
			$sequence->drop(strtoupper($this->tableName . '_cate_id_SEQ'));
		}
	}
}

