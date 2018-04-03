<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleinoutmanageTable extends Migration
{
	private $tableName='peopleinout_manage';
	private $tableComment='人员出入管理';
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create($this->tableName, function (Blueprint $table) {
			$table->increments('pio_id')->comment('出入记录编号');
			$table->integer('storeroom_id',false,true)->comment('库房编号');
			$table->timestamp('comein_time')->nullable()->commment('入库时间');
			$table->timestamp('plan_goout_time')->nullable()->commment('预计入库时间');
			$table->timestamp('real_goout_time')->nullable()->commment('实际入库时间');
			$table->string('comein_member',100)->commment('入库人员');
			$table->string('with_member',100)->commment('陪同入库人员')->nullable();
			$table->string('comein_department',100)->commment('进库人单位')->nullable();
			$table->text('reason')->commment('出入事由')->nullable();
			$table->string('remark',255)->commment('备注')->nullable();
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
        Schema::dropIfExists('peopleinout_manage');
    }
}
