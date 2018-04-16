<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrameTable extends Migration
{
    private $tableName='frame';
    private $tableComment='排架信息表';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments('frame_id')->comment('排架ID');
            $table->string('room_number',50)->comment('库房库位编号')->default('');
            $table->string('frame_name')->comment('排架名称')->nullable()->default('');
            $table->string('frame_number')->comment('排架编号')->nullable()->default('');
            $table->string('exhibit_sum_register_ids')->comment('展品ID的数组')->nullable()->default('');
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
    }
}
