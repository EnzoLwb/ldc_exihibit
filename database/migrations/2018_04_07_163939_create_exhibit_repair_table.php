<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExhibitRepairTable extends Migration
{
	private $tableName = 'repair_apply';
	private $tableComment = '藏品修复申请';
	private $primaryKey = 'repair_id';
	/**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
			$table->increments($this->primaryKey);
			$table->string('repair_order_no',50)->comment('修复申请单号');
			$table->string('repair_order_name',50)->comment('修复申请单名称');
			$table->integer('plan_expense')->default(0)->nullable()->comment('经费预算');
			$table->tinyInteger('apply_status',false,true)->default('0')->comment('申请状态 0 未提交申请，1 等待审批 2 审批通过 3 审批拒绝');
			$table->string('register_member',20)->nullable()->comment('登记人');
			$table->timestamp('register_date')->nullable()->comment('登记日期');
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
