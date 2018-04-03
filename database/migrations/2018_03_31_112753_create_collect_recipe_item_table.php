<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectRecipeItemTable extends Migration
{
    private $tableName = 'collect_recipe_item';
    private $tableComment = '入馆明细表';
    private $primaryKey = 'collect_recipe_item_id';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments($this->primaryKey);
            $table->integer('collect_recipe_id')->nullable()->default(0)->comment('入馆凭证号');
            $table->integer('exhibit_sum_register_id')->nullable()->default(0)->comment('文物总登记号');
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
