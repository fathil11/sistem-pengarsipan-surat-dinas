<?php

use App\UserDepartment;
use App\UserPosition;
use App\UserPositionDetail;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// use Faker\Factory;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $faker = Faker\Factory::create('id_ID');

        $position = 'Admin';
        DB::table('users')->insert([
            'nip' => $faker->nik(),
            'name' => $position,
            'user_position_id' => UserPosition::getPositionId($position),
            // 'user_position_detail_id => 1,
            // 'user_department_id => 1,
            'email' => $faker->email(),
            'username' => $faker->userName(),
            'phone_number' => $faker->phoneNumber(),
            'password' => Hash::make('123123')
        ]);

        $position = 'Kepala Dinas';
        DB::table('users')->insert([
            'nip' => $faker->nik(),
            'name' => $position,
            'user_position_id' => UserPosition::getPositionId($position),
            // 'user_position_detail_id => 1,
            // 'user_department_id => 1,
            'email' => $faker->email(),
            'username' => $faker->userName(),
            'phone_number' => $faker->phoneNumber(),
            'password' => Hash::make('123123')
        ]);

        $position = 'Asisten Kepala Dinas';
        DB::table('users')->insert([
            'nip' => $faker->nik(),
            'name' => $position,
            'user_position_id' => UserPosition::getPositionId($position),
            // 'user_position_detail_id => 1,
            // 'user_department_id => 1,
            'email' => $faker->email(),
            'username' => $faker->userName(),
            'phone_number' => $faker->phoneNumber(),
            'password' => Hash::make('123123')
        ]);

        $position = 'Sekretaris';
        DB::table('users')->insert([
            'nip' => $faker->nik(),
            'name' => $position,
            'user_position_id' => UserPosition::getPositionId($position),
            // 'user_position_detail_id => 1,
            // 'user_department_id => 1,
            'email' => $faker->email(),
            'username' => $faker->userName(),
            'phone_number' => $faker->phoneNumber(),
            'password' => Hash::make('123123')
        ]);

        $position = 'Asisten Sekretaris';
        DB::table('users')->insert([
            'nip' => $faker->nik(),
            'name' => $position,
            'user_position_id' => UserPosition::getPositionId($position),
            // 'user_position_detail_id => 1,
            // 'user_department_id => 1,
            'email' => $faker->email(),
            'username' => $faker->userName(),
            'phone_number' => $faker->phoneNumber(),
            'password' => Hash::make('123123')
        ]);

        $position = 'Kepala TU';
        DB::table('users')->insert([
            'nip' => $faker->nik(),
            'name' => $position,
            'user_position_id' => UserPosition::getPositionId($position),
            // 'user_position_detail_id => 1,
            // 'user_department_id => 1,
            'email' => $faker->email(),
            'username' => $faker->userName(),
            'phone_number' => $faker->phoneNumber(),
            'password' => Hash::make('123123')
        ]);

        $position = 'Asisten Kepala TU';
        DB::table('users')->insert([
            'nip' => $faker->nik(),
            'name' => $position,
            'user_position_id' => UserPosition::getPositionId($position),
            // 'user_position_detail_id => 1,
            // 'user_department_id => 1,
            'email' => $faker->email(),
            'username' => $faker->userName(),
            'phone_number' => $faker->phoneNumber(),
            'password' => Hash::make('123123')
        ]);

        $positions = UserPosition::whereIn('role', ['kepala_bidang', 'kepala_seksie'])->get();

        foreach ($positions as $position) {
            // $position = $position->position;
            $departments = UserDepartment::all();

            foreach ($departments as $department) {
                if ($position->role == 'kepala_bidang') {
                    DB::table('users')->insert([
                    'nip' => $faker->nik(),
                    'name' => $position->position . ' ' . $department->department_abbreviation,
                    'user_position_id' => UserPosition::getPositionId($position->position),
                    'user_position_detail_id' => UserPositionDetail::where('position_detail', 'Unknown')->first()->id,
                    'user_department_id' => $department->id,
                    'email' => $faker->email(),
                    'username' => $faker->userName(),
                    'phone_number' => $faker->phoneNumber(),
                    'password' => Hash::make('123123'),
                    'created_at' => Carbon::now(),
                    ]);
                } else {
                    for ($i=1; $i < 4; $i++) {
                        DB::table('users')->insert([
                            'nip' => $faker->nik(),
                            'name' => $position->position . ' ' . $department->department_abbreviation . ' ' . $i,
                            'user_position_id' => UserPosition::getPositionId($position->position),
                            'user_position_detail_id' => UserPositionDetail::where('position_detail', $i)->first()->id,
                            'user_department_id' => $department->id,
                            'email' => $faker->email(),
                            'username' => $faker->userName(),
                            'phone_number' => $faker->phoneNumber(),
                            'password' => Hash::make('123123'),
                            'created_at' => Carbon::now(),
                        ]);
                    }
                }
            }
        }
    }
}
