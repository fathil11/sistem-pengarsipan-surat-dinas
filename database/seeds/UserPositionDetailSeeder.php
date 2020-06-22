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
            'position_detail' => 'Ketua Bidang IPTEK'
        ]);

        DB::table('user_position_details')->insert([
            'position_detail' => 'Ketua Bidang INFOKOM'
        ]);

        DB::table('user_position_details')->insert([
            'position_detail' => 'Ketua Bidang LITBANG'
        ]);

        DB::table('user_position_details')->insert([
            'position_detail' => 'Ketua Seksie Perkap'
        ]);

        DB::table('user_position_details')->insert([
            'position_detail' => 'Ketua Seksie Sistem'
        ]);
    }
}
