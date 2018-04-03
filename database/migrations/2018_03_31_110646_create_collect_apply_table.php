<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectApplyTable extends Migration
{
    private $tableName = 'collect_apply';
    private $tableComment = '征集申请表';
    private $primaryKey = 'collect_apply_id';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments($this->primaryKey);
            $table->string('register_date', 50)->nullable()->comment('登记日期');
            $table->string('collect_apply_num', 50)->nullable()->comment('征集申请单号');
            $table->string('collect_apply_depart_name', 50)->nullable()->comment('征集申请单位名称');
            $table->string('collect_buy_object', 100)->nullable()->comment('征集采购对象');
            $table->string('collect_apply_project_name', 100)->nullable()->comment('征集项目名称');
            $table->string('apply_depart', 100)->nullable()->comment('申请部门');
            $table->string('need_fee', 100)->nullable()->comment('所需经费');
            $table->string('collect_exhibit_count', 100)->nullable()->comment('征集数量');
            $table->string('applyer', 100)->nullable()->comment('征集人');
            $table->text('collect_project_desc')->nullable()->comment('征集项目介绍');
            $table->text('collect_reason')->nullabel()->comment('征集原因');
            $table->string('files', 512)->nullable()->comment('附件');
            $table->tinyInteger("status")->default(0)->nullable()->comment('状态：0 草稿状态，1 等待审批 2 审批通过 3 审批拒绝');
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
        if (env('DB_CONNECTION') == 'oracle') {
            $sequence = DB::getSequence();
            $sequence->drop(strtoupper($this->tableName . '_' . $this->primaryKey . '_SEQ'));
        }
    }
}
