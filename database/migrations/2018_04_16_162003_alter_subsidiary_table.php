<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSubsidiaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subsidiary', function (Blueprint $table) {
            $table->string('room_number',50)->nullable()->default(0)->comment('关联库房编号')
                ->default('')->after('apply_status');
            $table->string('frame_id',50)->nullable()->default(0)->comment('关联库房排架ID')
                ->default('')->after('room_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
