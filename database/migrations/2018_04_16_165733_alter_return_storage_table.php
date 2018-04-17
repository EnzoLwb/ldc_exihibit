<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterReturnStorageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('return_storage', function (Blueprint $table) {
            $table->string('room_number',50)->nullable()->default(0)->comment('关联库房编号')
                ->default('')->after('status');
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
