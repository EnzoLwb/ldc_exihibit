<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomlistTable extends Migration
{
	private $tableName='room_list';
	private $tableComment='库房盘点管理';
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create($this->tableName, function (Blueprint $table) {
			$table->increments('check_id')->comment('盘点id');
			$table->string('room_number',50)->comment('库房库位编号');
			$table->string('plan_member',50)->comment('计划盘点人员');
			$table->timestamp('plan_date')->comment('计划盘点日期');
			$table->tinyInteger('apply_status',false,true)->default('2')->comment('申请是否通过 1为通过 0为未通过 2为审核中');
			$table->tinyInteger('check_status',false,true)->default('0')->comment('盘点是否完成 1为已完成 0为未完成 2为正在执行');
			$table->integer('goods_count',false,true)->comment('盘点文物数量')->nullable();
			$table->integer('completed_count',false,true)->default(0)->comment('完整文物数量');
			$table->integer('imcompleted_count',false,true)->default(0)->comment('残缺文物数量');
			$table->text('apply_remark')->comment('盘点申请备注')->nullable();
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
        Schema::dropIfExists('room_list');
    }
}
