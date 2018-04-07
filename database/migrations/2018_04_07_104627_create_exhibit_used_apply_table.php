<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExhibitUsedApplyTable extends Migration
{
    private $tableName = 'exhibit_used_apply';
    private $tableComment = '展品使用申请表';
    private $primaryKey = 'exhibit_used_apply_id';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments($this->primaryKey);
            $table->string('apply_depart_name')->nullable()->comment('申请部门名称');
            $table->string('executer')->nullable()->comment('经办人');
            $table->string('connectioner')->nullable()->comment('联系人');
            $table->string('phone',100)->nullable()->comment('联系方式');
            $table->string('outer_time',100)->nullable()->comment('出库时间');
            $table->string('outer_destination',100)->nullable()->comment('出库目的');
            $table->string('exhibit_list')->nullable()->comment('展品清单');
            $table->tinyInteger('type')->nullable()->comment('出库类型，出库，提用，观摩');
            $table->tinyInteger('status')->nullable()->comment('当前状态， 草稿，等待审核，通过，拒绝，完成');
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
