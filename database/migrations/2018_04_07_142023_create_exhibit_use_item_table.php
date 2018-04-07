<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExhibitUseItemTable extends Migration
{
    private $tableName = 'exhibit_use_item';
    private $tableComment = '展品使用单子';
    private $primaryKey = 'exhibit_use_item_id';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments($this->primaryKey);
            $table->integer('exhibit_sum_register_id')->nullable()->comment('总登记号');
            $table->integer('num')->default(0)->nullable()->comment('件数');
            $table->integer('exhibit_use_id')->default(0)->nullable()->comment('出库单据ID');
            $table->string('backup_time')->default('')->nullable()->comment('归还时间');
            $table->text('backup')->nullable()->comment('备注');

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
