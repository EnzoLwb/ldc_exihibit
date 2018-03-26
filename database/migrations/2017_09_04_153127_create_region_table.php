<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateRegionTable extends Migration
{
	private $tableName = 'region';
	private $tableComment = '地区库';
	private $primaryKey = 'region_id';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create($this->tableName, function (Blueprint $table) {
			$table->increments($this->primaryKey);
			//			$table->integer($this->primaryKey, false, true)->comment('地区id');
			$table->string('region_name', 100)->comment('地区名称');
			$table->integer('parent_id', false, true)->comment('上级地区id')->default(0);
			$table->tinyInteger('sort_order', false, true)->comment('地区显示顺序')->default(255);
			$table->tinyInteger('layer', false, true)->comment('地区层级数')->default(0);
			//			$table->primary($this->primaryKey);

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
