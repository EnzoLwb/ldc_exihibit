<?php

use Illuminate\Database\Seeder;

class StorageRoomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0;$i<10;$i++){
			DB::table('storage_room')->insert([
				'room_number' => 'TJ00'.$i,
				'room_name' => '填充库房'.$i,
				'ifstorage' => rand(0,1),
				'status' => rand(0,1),
			]);
		}
    }
}
