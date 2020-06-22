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
            'role' => 'Admin'
        ]);

        DB::table('user_positions')->insert([
            'position' => 'Kepala Dinas',
            'role' => 'Kepala Dinas'
        ]);

        DB::table('user_positions')->insert([
            'position' => 'Asisten Kepala Dinas',
            'role' => 'Kepala Dinas'
        ]);

        DB::table('user_positions')->insert([
            'position' => 'Sekretaris',
            'role' => 'Sekretaris'
        ]);

        DB::table('user_positions')->insert([
            'position' => 'Ketua Bidang',
            'role' => 'Kepala Bidang'
        ]);

        DB::table('user_positions')->insert([
            'position' => 'Ketua Seksie',
            'role' => 'Ketua Seksie'
        ]);
    }
}
