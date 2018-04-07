<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisinfectionTable extends Migration
{
    private $tableName = 'disinfection';
    private $tableComment = '消毒记录表';
    private $primaryKey = 'disinfection_id';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments($this->primaryKey);
            $table->integer('exhibit_sum_register_id')->nullable()->comment('关联的藏品主键ID');
            $table->string('clean_way',50)->nullable()->comment('清洁方式');
            $table->string('disinfection_way',100)->nullable()->comment('消毒方式');
            $table->string('clean_date',100)->nullable()->comment('清洁日期');
            $table->string('recorder',100)->nullable()->comment('录入人');
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
