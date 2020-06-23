<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'nip' => '00000',
            'name' => 'Super Admin',
            'user_position_id' => 1,
            // 'user_position_detail_id => 1,
            // 'user_department_id => 1,
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'password' => Hash::make('123123')
        ]);

        DB::table('users')->insert([
            'nip' => '00001',
            'name' => 'Bambang Sudibyo',
            'user_position_id' => 2,
            // 'user_position_detail_id' => 1,
            // 'user_department_id' => 1,
            'email' => 'bambang@gmail.com',
            'username' => 'bambang',
            'password' => Hash::make('123123')
        ]);

        DB::table('users')->insert([
            'nip' => '00002',
            'name' => 'Wiwik Hanura',
            'user_position_id' => 3,
            // 'user_position_detail_id' => 1,
            // 'user_department_id' => 1,
            'email' => 'wiwik@gmail.com',
            'username' => 'wiwik',
            'password' => Hash::make('123123')
        ]);

        DB::table('users')->insert([
            'nip' => '00003',
            'name' => 'Rini Syahrini',
            'user_position_id' => 4,
            // 'user_position_detail_id' => 1,
            // 'user_department_id' => 1,
            'email' => 'rini@gmail.com',
            'username' => 'rini',
            'password' => Hash::make('123123')
        ]);

        DB::table('users')->insert([
            'nip' => '00004',
            'name' => 'Jono Setiabudi',
            'user_position_id' => 5,
            'user_position_detail_id' => 1,
            'user_department_id' => 1,
            'email' => 'jono@gmail.com',
            'username' => 'jono',
            'password' => Hash::make('123123')
        ]);

        DB::table('users')->insert([
            'nip' => '00005',
            'name' => 'Arif Budiman',
            'user_position_id' => 5,
            'user_position_detail_id' => 2,
            'user_department_id' => 3,
            'email' => 'arif@gmail.com',
            'username' => 'arif',
            'password' => Hash::make('123123')
        ]);

        DB::table('users')->insert([
            'nip' => '00006',
            'name' => 'Eka Hermawan',
            'user_position_id' => 6,
            'user_position_detail_id' => 4,
            'user_department_id' => 1,
            'email' => 'eka@gmail.com',
            'username' => 'eka',
            'password' => Hash::make('123123')
        ]);

        DB::table('users')->insert([
            'nip' => '00007',
            'name' => 'Wily',
            'user_position_id' => 7,
            // 'user_position_detail_id' => 4,
            // 'user_department_id' => 1,
            'email' => 'wily@gmail.com',
            'username' => 'wilyeka',
            'password' => Hash::make('123123')
        ]);

        DB::table('users')->insert([
            'nip' => '00008',
            'name' => 'Syahrul Santoro',
            'user_position_id' => 4,
            // 'user_position_detail_id' => 1,
            // 'user_department_id' => 1,
            'email' => 'syahrul@gmail.com',
            'username' => 'syahrul',
            'password' => Hash::make('123123')
        ]);
    }
}
