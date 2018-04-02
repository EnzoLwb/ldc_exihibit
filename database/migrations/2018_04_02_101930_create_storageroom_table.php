<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorageroomTable extends Migration
{
	private $tableName='storage_room';
	private $tableComment='库房结构管理';
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
			$table->string('room_name',50)->commment('库房库位名称');
			$table->tinyInteger('ifstorage',false,true)->commment('是否库位');
			$table->tinyInteger('status',false,true)->commment('是否生效 1为生效 0为不生效');
			$table->string('room_type',50)->commment('库房类型')->default('一级库房');
			$table->string('save_type',50)->commment('存储方式')->nullable();
			$table->string('room_size',50)->commment('库房大小')->nullable();
			$table->string('position',50)->commment('位置')->nullable();
			$table->string('leader',50)->commment('负责人')->nullable();
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
        Schema::dropIfExists('storageroom');
    }
}
