<?php
namespace Seed\Production;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
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
            'nip' => '19680525 200012 1 005',
            'name' => 'Dr. Ahmad Jawahir',
            'user_position_id' => 2,
            'email' => 'kepaladinas@dinkesmelawi.com',
            'phone_number' => '082225210125',
            'username' => 'kepaladinas',
            'password' => Hash::make('123123'),
        ]);

        User::create([
            'nip' => '19710610 200212 1 006',
            'name' => 'Dr. Gunadi Linoh',
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

        // KABID
        User::create([
            'nip' => '197012231991012001',
            'name' => 'Indriyani Darmowiyoto, S.Sos',
            'user_position_id' => 5,
            'user_department_id' => 1,
            'email' => 'kabid1@dinkesmelawi.com',
            'phone_number' => '082225210125',
            'username' => 'kabid1',
            'password' => Hash::make('123123'),
        ]);

        User::create([
            'nip' => '197101241997031 005',
            'name' => 'Arif Santoso, Skm.,Mkm',
            'user_position_id' => 5,
            'user_department_id' => 2,
            'email' => 'kabid2@dinkesmelawi.com',
            'phone_number' => '082225210125',
            'username' => 'kabid2',
            'password' => Hash::make('123123'),
        ]);

        User::create([
            'nip' => '19740804 200502 1 002',
            'name' => 'Dr. Tanjung Harapan. T',
            'user_position_id' => 5,
            'user_department_id' => 3,
            'email' => 'kabid3@dinkesmelawi.com',
            'phone_number' => '082225210125',
            'username' => 'kabid3',
            'password' => Hash::make('123123'),
        ]);

        // KASIE
        User::create([
            'nip' => '19711105 199203 2 007',
            'name' => 'Supridayanti, S.Sos',
            'user_position_id' => 6,
            'user_department_id' => 1,
            'user_position_detail_id' => 1,
            'email' => 'kasie1@dinkesmelawi.com',
            'phone_number' => '082225210125',
            'username' => 'kasie1',
            'password' => Hash::make('123123'),
        ]);

        User::create([
            'nip' => '19640320 198703 1 014',
            'name' => 'Eppeda, S.St',
            'user_position_id' => 6,
            'user_department_id' => 1,
            'user_position_detail_id' => 2,
            'email' => 'kasie2@dinkesmelawi.com',
            'phone_number' => '082225210125',
            'username' => 'kasie2',
            'password' => Hash::make('123123'),
        ]);

        User::create([
            'nip' => '19670608 198801 2 003',
            'name' => 'Dwi Susan. P',
            'user_position_id' => 6,
            'user_department_id' => 1,
            'user_position_detail_id' => 3,
            'email' => 'kasie3@dinkesmelawi.com',
            'phone_number' => '082225210125',
            'username' => 'kasie3',
            'password' => Hash::make('123123'),
        ]);

        User::create([
            'nip' => '19720818 199201 1 001',
            'name' => 'Puspawati, A.Md.Keb',
            'user_position_id' => 6,
            'user_department_id' => 2,
            'user_position_detail_id' => 1,
            'email' => 'kasie4@dinkesmelawi.com',
            'phone_number' => '082225210125',
            'username' => 'kasie4',
            'password' => Hash::make('123123'),
        ]);

        User::create([
            'nip' => '19721010 199201 2 001',
            'name' => 'Khairunisa, S.Sos',
            'user_position_id' => 6,
            'user_department_id' => 2,
            'user_position_detail_id' => 2,
            'email' => 'kasie5@dinkesmelawi.com',
            'phone_number' => '082225210125',
            'username' => 'kasie5',
            'password' => Hash::make('123123'),
        ]);

        User::create([
            'nip' => '19690404 199103 1 015',
            'name' => 'Chairul Anam, S.Sos',
            'user_position_id' => 6,
            'user_department_id' => 2,
            'user_position_detail_id' => 3,
            'email' => 'kasie6@dinkesmelawi.com',
            'phone_number' => '082225210125',
            'username' => 'kasie6',
            'password' => Hash::make('123123'),
        ]);

        User::create([
            'nip' => '19681120 198911 1 001',
            'name' => 'Musadar, S.Sos',
            'user_position_id' => 6,
            'user_department_id' => 3,
            'user_position_detail_id' => 1,
            'email' => 'kasie7@dinkesmelawi.com',
            'phone_number' => '082225210125',
            'username' => 'kasie7',
            'password' => Hash::make('123123'),
        ]);

        User::create([
            'nip' => '19750409 200312 1 006',
            'name' => 'Rianto, S.Si.Apt.,Mm',
            'user_position_id' => 6,
            'user_department_id' => 3,
            'user_position_detail_id' => 2,
            'email' => 'kasie8@dinkesmelawi.com',
            'phone_number' => '082225210125',
            'username' => 'kasie8',
            'password' => Hash::make('123123'),
        ]);

        User::create([
            'nip' => '19620218 198703 1 012',
            'name' => 'Sabarudin',
            'user_position_id' => 6,
            'user_department_id' => 3,
            'user_position_detail_id' => 3,
            'email' => 'kasie9@dinkesmelawi.com',
            'phone_number' => '082225210125',
            'username' => 'kasie9',
            'password' => Hash::make('123123'),
        ]);


    }
}
