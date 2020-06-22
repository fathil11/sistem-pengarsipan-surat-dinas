<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_positions')->insert([
            'position' => 'Admin',
            'role' => 'admin'
        ]);

        DB::table('user_positions')->insert([
            'position' => 'Kepala Dinas',
            'role' => 'kepala_dinas'
        ]);

        DB::table('user_positions')->insert([
            'position' => 'Asisten Kepala Dinas',
            'role' => 'kepala_dinas'
        ]);

        DB::table('user_positions')->insert([
            'position' => 'Sekretaris',
            'role' => 'sekretaris'
        ]);

        DB::table('user_positions')->insert([
            'position' => 'Kepala Bidang',
            'role' => 'kepala_bidang'
        ]);

        DB::table('user_positions')->insert([
            'position' => 'Kepala Seksie',
            'role' => 'kepala_seksie'
        ]);

        DB::table('user_positions')->insert([
            'position' => 'Kepala TU',
            'role' => 'kepala_tu'
        ]);
    }
}
