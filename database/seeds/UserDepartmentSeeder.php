<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_departments')->insert([
            'department' => 'Ilmu Pengetahuan dan Teknologi',
            'department_abbreviation' => 'IPTEK'
        ]);

        DB::table('user_departments')->insert([
            'department' => 'Penelitian dan Pengembangan',
            'department_abbreviation' => 'LITBANG'
        ]);

        DB::table('user_departments')->insert([
            'department' => 'Informasi dan Komunikasi',
            'department_abbreviation' => 'INFOKOM'
        ]);
    }
}
