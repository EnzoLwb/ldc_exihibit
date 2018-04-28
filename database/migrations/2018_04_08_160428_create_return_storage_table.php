<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReturnStorageTable extends Migration
{
    private $tableName = 'return_storage';
    private $tableComment = '回库管理表';
    private $primaryKey = 'return_storage_id';

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
            $table->string('returner')->default('')->nullable()->comment('退还人');
            $table->string('taker')->nullable()->comment('点收人');
            $table->string('return_date')->nullable()->comment('归还日期');
            $table->string('recorder')->nullable()->comment('录入人');
            $table->tinyInteger('status')->nullable()->default(0)->comment('状态，草稿或者提交生效');
            $table->text('mark')->nullable()->comment('备注');
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
