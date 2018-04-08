<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccidentTable extends Migration
{
    private $tableName = 'accident';
    private $tableComment = '事故登记单子';
    private $primaryKey = 'accident_id';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments($this->primaryKey);
            $table->integer('exhibit_sum_register_id')->nullable()->comment('关联展品总登记号');
            $table->string('accident_time')->default('')->nullable()->comment('事故发生时间');
            $table->string('accident_maker')->nullable()->comment('事故造成人');
            $table->string('result_maker')->nullable()->comment('事故处理单位');
            $table->string('recorder')->nullable()->comment('录入人');
            $table->tinyInteger('status')->nullable()->default(0)->comment('状态，草稿或者审核通过，或者审核拒绝');
            $table->text('accident_desc')->comment('事故描述');
            $table->text('proc_dependy')->comment('处理依据');
            $table->text('proc_suggestion')->comment('处理意见');

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
