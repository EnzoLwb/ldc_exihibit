<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorageroomTable extends Migration
{
	private $tableName='storage_room';
	private $tableComment='库房管理';
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create($this->tableName, function (Blueprint $table) {
			$table->increments('room_id')->comment('库房id');
			$table->string('room_number',50)->unique()->comment('库房库位编号');
			$table->string('room_name',50)->comment('库房库位名称');
			$table->tinyInteger('ifstorage',false,true)->comment('是否库位');
			$table->tinyInteger('status',false,true)->comment('是否生效 1为生效 0为不生效');
			$table->string('room_type',50)->comment('库房类型')->default('一级库房');
			$table->string('save_type',50)->comment('存储方式')->nullable();
			$table->string('room_size',50)->comment('库房大小')->nullable();
			$table->string('position',50)->comment('位置')->nullable();
			$table->string('leader',50)->comment('负责人')->nullable();
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
