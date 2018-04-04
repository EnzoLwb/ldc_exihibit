<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdentifyResultTable extends Migration
{
    private $tableName = 'identify_result';
    private $tableComment = '鉴定结果';
    private $primaryKey = 'identify_result_id';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments($this->primaryKey);
            $table->integer('identify_apply_id')->nullable()->comment('鉴定申请ID');
            $table->integer('identify_maker')->nullable()->comment('鉴定人');
            $table->integer('exhibit_sum_register_id')->nullable()->comment('总登记号');
            $table->text('identify_result')->nullable()->comment('鉴定成果');
            $table->string('name',100)->nullable()->comment('名称');
            $table->string('age',100)->nullable()->comment('年代');
            $table->string('exhibit_level',100)->nullable()->comment('藏品级别');
            $table->string('type',100)->nullable()->comment('藏品类别');
            $table->string('quality',100)->nullable()->comment('藏品质地');
            $table->string('complete_degree',100)->nullable()->comment('完残程度');
            $table->string('files',100)->nullable()->comment('图片');
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
