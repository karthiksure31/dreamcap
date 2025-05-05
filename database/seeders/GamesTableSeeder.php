<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('games')->insert([
            ['game_name' => 'Cricket', 'created_at' => null, 'updated_at' => null]
        ]);
    }
}
