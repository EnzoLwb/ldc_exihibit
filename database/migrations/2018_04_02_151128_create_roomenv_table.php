<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomenvTable extends Migration
{
	private $tableName='room_env';
	private $tableComment='库房环境管理';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments('book_id');
			$table->string('room_number',50)->comment('库房库位编号');
			$table->string('temp',50)->comment('库房温度')->nullable();
			$table->string('damp',50)->comment('库房湿度')->nullable();
			$table->string('air',50)->comment('空气净化程度')->nullable();
			$table->string('light',50)->comment('库房光照率')->nullable();
			$table->string('booker',50)->comment('登记人')->nullable();
			$table->timestamp('book_time')->comment('登记日期');
			$table->text('remark')->comment('备注')->nullable();
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
