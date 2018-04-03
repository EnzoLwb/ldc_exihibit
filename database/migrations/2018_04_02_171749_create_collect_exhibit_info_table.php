<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectExhibitInfoTable extends Migration
{
    private $tableName = 'collect_exhibit';
    private $tableComment = '入馆文物明细';
    private $primaryKey = 'collect_exhibit_id';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments($this->primaryKey);
            $table->string('exhibit_sum_register_num', 50)->nullable()->comment('总登记号');
            $table->string('name', 50)->nullable()->comment('现用名');
            $table->string('age', 50)->nullable()->comment('具体年代');
            $table->string('type', 50)->nullable()->comment('类别');
            $table->string('type_num', 50)->nullable()->comment('分类号');
            $table->string('type_order_num', 50)->nullable()->comment('分类单号');
            $table->string('rubbing_num', 50)->nullable()->comment('拓片号');
            $table->string('baseboard_num', 50)->nullable()->comment('底板号');
            $table->string('num', 50)->nullable()->comment('实际数量');
            $table->string('num_uint', 50)->nullable()->comment('实际数量单位');
            $table->string('quality', 50)->nullable()->comment('具体质量');
            $table->string('lwh', 50)->nullable()->comment('长宽高');
            $table->string('exhibit_level', 50)->nullable()->comment('文物级别');
            $table->string('complete_degree', 50)->nullable()->comment('完残程度');
            $table->integer('collect_recipe_id')->nullable()->comment('入馆凭证数据ID');
            $table->text('files')->nullable()->comment('附件');
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
