<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserPositionDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_position_details')->insert([
            'position_detail' => 'Unknown'
        ]);

        DB::table('user_position_details')->insert([
            'position_detail' => '1'
        ]);

        DB::table('user_position_details')->insert([
            'position_detail' => '2'
        ]);

        DB::table('user_position_details')->insert([
            'position_detail' => '3'
        ]);
    }
}
