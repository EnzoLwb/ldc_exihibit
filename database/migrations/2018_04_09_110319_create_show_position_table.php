<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShowPositionTable extends Migration
{
    private $tableName = 'show_position';
    private $tableComment = '展位信息表';
    private $primaryKey = 'show_position_id';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments($this->primaryKey);
            $table->string('name')->default('')->nullable()->comment('展位名称');
            $table->integer('show_apply_id')->default(0)->nullable()->comment('所属展览ID');
            $table->string('num')->nullable()->default('')->comment('展位编码');
            $table->string('show_way')->nullable()->default('')->comment('展陈方式');
            $table->tinyInteger('is_last_level')->nullable()->default(0)->comment('是否末级');
            $table->tinyInteger('is_valid')->nullable()->default(0)->comment('是否生效');
            $table->string('position')->nullable()->default('')->comment('位置');
            $table->string('responser')->nullable()->default('')->comment('负责人');
            $table->tinyInteger('in_use')->nullable()->default(0)->comment('是否在使用当中');
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
