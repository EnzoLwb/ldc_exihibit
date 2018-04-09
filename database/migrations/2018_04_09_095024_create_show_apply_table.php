<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShowApplyTable extends Migration
{
    private $tableName = 'show_apply';
    private $tableComment = '展览申请表';
    private $primaryKey = 'show_apply_id';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments($this->primaryKey);
            $table->string('applyer')->default('')->nullable()->comment('申请人');
            $table->string('apply_time')->nullable()->default('')->comment('申请时间');
            $table->string('theme')->nullable()->default('')->comment('展览主题');
            $table->string('exhibitor')->nullable()->default('')->comment('参展人员');
            $table->string('show_num')->nullable()->default('')->comment('展览编号');
            $table->string('start_date')->nullable()->default('')->comment('开始日期');
            $table->string('end_date')->nullable()->default('')->comment('结束日期');
            $table->tinyInteger('status')->nullable()->default(0)->comment('状态，草稿或者提交生效');
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
