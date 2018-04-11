<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExhibitIntoStorageroomTable extends Migration
{
    private $tableName = 'exhibit_into_room';
    private $tableComment = '入库申请表';
    private $primaryKey = 'exhibit_into_room_id';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments($this->primaryKey);
            $table->integer('exhibit_sum_register_id')->default(0)->nullable()->comment('展品表');
            $table->string('room_number')->default('')->nullable()->comment('库房编号');
            $table->string('in_room_recipe_num')->default('')->nullable()->comment('入库凭证号');
            $table->tinyInteger('status')->default(0)->nullable()->comment('状态');
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
