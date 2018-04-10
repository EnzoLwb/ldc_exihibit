<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubsidiaryTable extends Migration
{
	private $tableName='subsidiary';
	private $tableComment='其它文物/辅助账';
	private $primaryKey = 'subsidiary_id';
	/**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments($this->primaryKey);
            $table->tinyInteger('type',false,true)->comment('类型 例如 未定级文物登记账,复制品登记账,仿制品登记账等等')->nullable();
            $table->string('collect_depart',50)->comment('收藏单位')->nullable();
            $table->string('attachment')->comment('附件地址')->nullable();
            $table->string('exhibit_sum_register_num',50)->comment('总登记号')->nullable();
            $table->string('ori_num',50)->comment('原编号')->nullable();
            $table->string('type_num',50)->comment('分类号')->nullable();
            $table->string('collect_recipe_num',50)->comment('入馆登记号')->nullable();
            $table->string('name',50)->comment('名称')->nullable();
            $table->string('ori_name',50)->comment('原名')->nullable();
            $table->string('age_type',50)->comment('年代类型')->nullable();
            $table->string('age',50)->comment('具体年代')->nullable();
            $table->string('history_step',50)->comment('历史阶段')->nullable();
            $table->string('textaure1',50)->comment('质地类型1')->nullable();
            $table->string('textaure2',50)->comment('质地类型2')->nullable();
            $table->string('common_textaure',50)->comment('普查质地')->nullable();
            $table->string('textaure',50)->comment('具体质地')->nullable();
            $table->string('range_type',50)->comment('类别范围')->nullable();
			$table->tinyInteger('apply_status',false,true)->default('0')->comment('申请状态 0 未提交申请，1 等待审批 2 审批通过 3 审批拒绝');
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
        Schema::dropIfExists('other_exhibit');
    }
}
