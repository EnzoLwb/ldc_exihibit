<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFakeExhibitTable extends Migration
{
    private $tableName = 'fake_exhibit';
    private $tableComment = '伪文物详情表';
    private $primaryKey = 'fake_exhibit_sum_register_id';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments($this->primaryKey);
            $table->integer('collect_recipe_id')->nullable()->default(0)->comment('入馆单据号');
            $table->string('collect_depart_name')->nullable()->default('')->comment('收藏单位名称');
            $table->string('exhibit_sum_register_num', 50)->nullable()->comment('总登记号');
            $table->tinyInteger('audit_status')->nullable()->comment('审核状态');
            $table->string('ori_num', 50)->nullable()->comment('原编号');
            $table->string('used_num', 50)->nullable()->comment('曾用号');
            $table->string('collect_recipe_num', 50)->nullable()->comment('入馆凭证号');
            $table->string('recipe_num', 50)->nullable()->comment('收据号');
            $table->string('name', 50)->nullable()->comment('现用名');
            $table->string('used_name', 50)->nullable()->comment('曾用名');
            $table->string('age_type', 50)->nullable()->comment('年代类型');
            $table->string('age', 50)->nullable()->comment('具体年代');
            $table->string('history_step', 50)->nullable()->comment('历史阶段');
            $table->string('textaure1', 50)->nullable()->comment('质地类型1');
            $table->string('textaure2', 50)->nullable()->comment('质地类型2');
            $table->string('common_textaure', 50)->nullable()->comment('普查地址');
            $table->string('textaure', 50)->nullable()->comment('具体地质');
            $table->string('range_type', 50)->nullable()->comment('类别范围');
            $table->string('type', 50)->nullable()->comment('类别');
            $table->string('type_num', 50)->nullable()->comment('分类号');
            $table->string('type_order_num', 50)->nullable()->comment('分类单号');
            $table->string('rubbing_num', 50)->nullable()->comment('拓片号');
            $table->string('baseboard_num', 50)->nullable()->comment('底板号');
            $table->string('common_num', 50)->nullable()->comment('传统数量');
            $table->string('common_num_uint', 50)->nullable()->comment('传统数量单位');
            $table->string('num', 50)->nullable()->comment('实际数量');
            $table->string('num_uint', 50)->nullable()->comment('实际数量单位');
            $table->string('quality', 50)->nullable()->comment('具体质量');
            $table->string('quality_range', 50)->nullable()->comment('质量范围');
            $table->string('size', 50)->nullable()->comment('尺寸');
            $table->string('lwh', 50)->nullable()->comment('长宽高');
            $table->string('exhibit_level', 50)->nullable()->comment('文物级别');
            $table->string('src_way', 50)->nullable()->comment('来源方式');
            $table->string('src', 50)->nullable()->comment('来源');
            $table->string('src_addition', 50)->nullable()->comment('来源补充');
            $table->string('complete_degree', 50)->nullable()->comment('完残程度');
            $table->string('complete_info', 50)->nullable()->comment('完残状况');
            $table->string('storage_status', 50)->nullable()->comment('保存状态');
            $table->string('in_museum_time', 50)->nullable()->comment('入馆时间');
            $table->string('in_museum_age', 50)->nullable()->comment('入馆年代');
            $table->string('in_museum_time_range', 50)->nullable()->comment('入馆时间范围');
            $table->string('storage_position', 50)->nullable()->comment('具体存放地址（本馆或者借展）');
            $table->string('ori_storage_position', 50)->nullable()->comment('原展厅具体位置');
            $table->string('room_gui_num', 50)->nullable()->comment('展厅柜号');
            $table->string('exhibit_property', 50)->nullable()->comment('藏品性质');
            $table->string('status', 50)->nullable()->comment('藏品状态');
            $table->string('room_number',50)->nullable()->commment('库房库位编号');
            $table->text('backup')->nullable()->comment('备注');
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
