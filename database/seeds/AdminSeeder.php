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
        User::create([
            'nip' => '00001',
            'name' => 'Admin',
            'user_position_id' => 1,
            'email' => 'admin@dinkesmelawi.com',
            'phone_number' => '082225210125',
            'username' => 'admin',
            'password' => Hash::make('123123'),
        ]);

        User::create([
            'nip' => '00002',
            'name' => 'Kepala Dinas',
            'user_position_id' => 2,
            'email' => 'kepaladinas@dinkesmelawi.com',
            'phone_number' => '082225210125',
            'username' => 'kepaladinas',
            'password' => Hash::make('123123'),
        ]);

        User::create([
            'nip' => '00003',
            'name' => 'Sekretaris',
            'user_position_id' => 3,
            'email' => 'sekretaris@dinkesmelawi.com',
            'phone_number' => '082225210125',
            'username' => 'sekretaris',
            'password' => Hash::make('123123'),
        ]);

        User::create([
            'nip' => '00004',
            'name' => 'Kepala TU',
            'user_position_id' => 4,
            'email' => 'kepalatu@dinkesmelawi.com',
            'phone_number' => '082225210125',
            'username' => 'kepalatu',
            'password' => Hash::make('123123'),
        ]);

        User::create([
            'nip' => '00005',
            'name' => 'Kepala Bidang 1',
            'user_position_id' => 5,
            'user_department_id' => 1,
            'email' => 'kabid1@dinkesmelawi.com',
            'phone_number' => '082225210125',
            'username' => 'kabid1',
            'password' => Hash::make('123123'),
        ]);

        User::create([
            'nip' => '00006',
            'name' => 'Kepala Bidang 2',
            'user_position_id' => 5,
            'user_department_id' => 2,
            'email' => 'kabid2@dinkesmelawi.com',
            'phone_number' => '082225210125',
            'username' => 'kabid2',
            'password' => Hash::make('123123'),
        ]);

        User::create([
            'nip' => '00007',
            'name' => 'Kepala Bidang 3',
            'user_position_id' => 5,
            'user_department_id' => 3,
            'email' => 'kabid3@dinkesmelawi.com',
            'phone_number' => '082225210125',
            'username' => 'kabid3',
            'password' => Hash::make('123123'),
        ]);
    }
}
