<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdentifyApplyTable extends Migration
{
    private $tableName = 'identify_apply';
    private $tableComment = '鉴定申请表';
    private $primaryKey = 'identify_apply_id';

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
            $table->string('identify_apply_depart', 50)->nullable()->comment('鉴定申请单位名称');
            $table->string('identify_date', 50)->nullable()->comment('鉴定日期');
            $table->string('identify_expert', 50)->nullable()->comment('鉴定专家');
            $table->string('identify_depart', 50)->nullable()->comment('鉴定部门');
            $table->string('status', 50)->nullable()->comment('状态');
            $table->string('register', 50)->nullable()->comment('登记人');
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
