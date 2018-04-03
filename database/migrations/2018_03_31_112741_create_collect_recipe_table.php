<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectRecipeTable extends Migration
{
    private $tableName = 'collect_recipe';
    private $tableComment = '入馆凭证表';
    private $primaryKey = 'collect_recipe_id';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments($this->primaryKey);
            $table->integer('collect_apply_id')->default(0)->nullable()->comment('征集入馆申请号,直接入馆是0');
            $table->string('collect_recipe_num', 50)->nullable()->comment('入馆凭证号');
            $table->string('collect_recipe_name', 50)->nullable()->comment('入馆凭证名称');
            $table->string('collect_date', 50)->nullable()->comment('入馆日期');
            $table->string('recipe_num', 50)->nullable()->comment('收据号');
            $table->tinyInteger('status')->nullable()->default(0)->comment('当前状态，0表示未提交总账，1表示已经提交总账');
            $table->text('mark')->comment('备注');
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
