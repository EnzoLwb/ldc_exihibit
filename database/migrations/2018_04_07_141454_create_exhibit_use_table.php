<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExhibitUseTable extends Migration
{
    private $tableName = 'exhibit_use';
    private $tableComment = '展品使用单子';
    private $primaryKey = 'exhibit_use_id';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments($this->primaryKey);
            $table->integer('exhibit_use_apply_id')->nullable()->default(0)->comment('申请单子');
            $table->string('depart_name')->nullable()->comment('提供部门');
            $table->string('outer_destination')->nullable()->comment('出库目的');
            $table->string('outer_time')->nullable()->comment('出库时间');
            $table->string('outer_sender',100)->nullable()->comment('库房点交人');
            $table->string('outer_taker',100)->nullable()->comment('提取经手人');
            $table->string('date',100)->nullable()->comment('日期');
            $table->tinyInteger('type')->nullable()->default(0)->comment('出库类型');
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
