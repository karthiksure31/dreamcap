<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('positions')->insert([
            ['position_name' => 'Wk', 'status' => 0, 'game_name' => 1, 'created_at' => null, 'updated_at' => null],
            ['position_name' => 'Bat', 'status' => 0, 'game_name' => 1, 'created_at' => null, 'updated_at' => null],
            ['position_name' => 'All', 'status' => 0, 'game_name' => 1, 'created_at' => null, 'updated_at' => null],
            ['position_name' => 'Bowl', 'status' => 0, 'game_name' => 1, 'created_at' => null, 'updated_at' => null],
        ]);
    }
}
