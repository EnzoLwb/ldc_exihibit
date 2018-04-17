<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsideRepairTable extends Migration
{
	private $tableName = 'inside_repair';
	private $tableComment = '内修文物管理';
	private $primaryKey = 'inside_repair_id';
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
			$table->string('repair_order_name',50)->comment('档案号');
			$table->integer('exhibit_sum_register_id',false,true)->comment('藏品id');
			$table->string('name',50)->comment('藏品名称');
			$table->tinyInteger('apply_status',false,true)->default('0')->comment('申请状态 0 未提交申请，1 等待审批 2 审批通过 3 审批拒绝');
			$table->string('host',50)->comment('主持人')->nullable();
			$table->string('restorer',50)->comment('修复人')->nullable();
			$table->string('header_signature',50)->comment('主任签字')->nullable();
			$table->string('curator_signature',50)->comment('馆长签字')->nullable();
			$table->text('exhibit_status')->comment('文物现状')->nullable();
			$table->text('repair_demand')->comment('修复要求')->nullable();
			$table->text('repair_history')->comment('修复历史')->nullable();
			$table->text('repair_scheme')->comment('修复方案')->nullable();
			$table->string('scheme_editor',50)->comment('方案制定人')->nullable();
			$table->string('scheme_checker',50)->comment('方案审定人')->nullable();
			$table->text('result')->comment('校验结果')->nullable();
			$table->text('process_data')->comment('修复经过及使用材料')->nullable();
			$table->timestamp('pickup_date')->comment('提取日期');
			$table->timestamp('return_date')->comment('归还日期');
			$table->string('acceptor',20)->nullable()->comment('验收人');
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
        Schema::dropIfExists($this->tableName);
    }
}
