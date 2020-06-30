<?php

use App\User;
use App\UserPosition;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserPosition::create([
            'position' => 'Admin',
            'role' => 'admin',
        ]);
        UserPosition::create([
            'position' => 'Kepala Dinas',
            'role' => 'kepala_dinas',
        ]);
        UserPosition::create([
            'position' => 'Sekretaris',
            'role' => 'sekretaris',
        ]);
        UserPosition::create([
            'position' => 'Kepala TU',
            'role' => 'kepala_tu',
        ]);
        UserPosition::create([
            'position' => 'Kepala Bidang',
            'role' => 'kepala_bidang',
        ]);
        UserPosition::create([
            'position' => 'Kepala Seksie',
            'role' => 'kepala_seksie',
        ]);

        User::create([
            'nip' => '11111',
            'name' => 'Admin',
            'user_position_id' => 1,
            'email' => 'admin@dinkesmelawi.com',
            'phone_number' => '082225210125',
            'username' => 'admin',
            'password' => Hash::make('123123'),
        ]);

        User::create([
            'nip' => '22222',
            'name' => 'Kepala Dinas',
            'user_position_id' => 2,
            'email' => 'kepaladinas@dinkesmelawi.com',
            'phone_number' => '082225210125',
            'username' => 'kepala_dinas',
            'password' => Hash::make('123123'),
        ]);

        User::create([
            'nip' => '33333',
            'name' => 'Sekretaris',
            'user_position_id' => 3,
            'email' => 'sekretaris@dinkesmelawi.com',
            'phone_number' => '082225210125',
            'username' => 'sekretaris',
            'password' => Hash::make('123123'),
        ]);

        User::create([
            'nip' => '44444',
            'name' => 'Kepala TU',
            'user_position_id' => 4,
            'email' => 'kepalatu@dinkesmelawi.com',
            'phone_number' => '082225210125',
            'username' => 'kepala_tu',
            'password' => Hash::make('123123'),
        ]);
    }
}
