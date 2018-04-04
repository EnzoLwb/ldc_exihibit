<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpertInfoTable extends Migration
{
    private $tableName = 'expert';
    private $tableComment = '专家信息表';
    private $primaryKey = 'expert_id';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments($this->primaryKey);
            $table->integer('admin_user_id')->nullable()->comment('管理员ID');
            $table->string('duties', 50)->nullable()->comment('职务');
            $table->string('sex', 5)->nullable()->comment('性别');
            $table->string('job_title', 50)->nullable()->comment('职称');
            $table->tinyInteger('status')->nullable()->comment('状态');
            $table->string('depart', 50)->nullable()->comment('所属部门');
            $table->text('identify_result')->nullable()->comment('鉴定成果');
            $table->string('profession_skills', 50)->nullable()->comment('专长');
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
