<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExhibitLogoutTable extends Migration
{
    protected $tableName='exhibit_logout';
    protected $tableComment='藏品注销';
    protected $primaryKey='logout_id';
	/**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exhibit_logout', function (Blueprint $table) {
            $table->increments($this->primaryKey);
			$table->string('logout_num',50)->comment('注销凭证号');
			$table->string('logout_name', 50)->comment('注销凭证名称');
			$table->string('logout_date', 50)->comment('注销日期');
			$table->string('logout_pizhun_num', 50)->comment('注销批准文号');
			$table->string('logout_reason', 50)->comment('注销原因')->nullable();
			$table->string('logout_desc', 50)->comment('详情描述')->nullable();
			$table->string('register', 50)->comment('登记人')->nullable();
			$table->timestamp('register_date')->comment('登记日期')->nullable();
			$table->tinyInteger("status")->default(0)->nullable()->comment('状态：0 未提交申请，1 等待审批 2 审批通过 3 审批拒绝');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exhibit_logout');
    }
}
