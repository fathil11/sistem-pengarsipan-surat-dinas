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
            'nip' => '007007007',
            'name' => 'Om Bambang',
            'user_position_id' => 1,
            'email' => 'admin@dinkesmelawi.com',
            'phone_number' => '082225210125',
            'username' => 'admin',
            'password' => Hash::make('123123'),
        ]);

        User::create([
            'nip' => '007007007',
            'name' => 'Sri Wahyuni',
            'user_position_id' => 4,
            'email' => 'sekretaris@dinkesmelawi.com',
            'phone_number' => '082225210125',
            'username' => 'admin',
            'password' => Hash::make('123123'),
        ]);
    }
}
