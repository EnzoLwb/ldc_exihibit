<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOutsideRepairTable extends Migration
{
	private $tableName = 'outside_repair';
	private $tableComment = '外修文物管理';
	private $primaryKey = 'outside_repair_id';
	/**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments($this->primaryKey);
			$table->string('before_pic',200)->comment('修复前图片地址')->nullable();
			$table->string('repairing_pic',200)->comment('修复中图片地址')->nullable();
			$table->string('after_pic',200)->comment('修复后图片地址')->nullable();
			$table->integer('exhibit_sum_register_id',false,true)->comment('藏品id');
			$table->string('name',50)->comment('藏品名称');
			$table->tinyInteger('apply_status',false,true)->default('0')->comment('申请状态 0 未提交申请，1 等待审批 2 审批通过 3 审批拒绝');
			$table->integer('repair_num',false,true)->comment('修复数量')->nullable();
			$table->integer('plan_price',false,true)->comment('估价')->nullable();
			$table->string('expert_signature',50)->comment('专家签字')->nullable();
			$table->text('incomplete_status')->comment('残缺情况')->nullable();
			$table->text('repair_require')->comment('修复要求')->nullable();
			$table->timestamp('date')->comment('日期');
			$table->string('account_type', 50)->default('exhibit')->comment('账目类型 exhibit为总账类型 subsidiary为辅助账类型');
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
        Schema::dropIfExists('outside_repair');
    }
}
