<?php

namespace Seed\Production;

use Illuminate\Database\Seeder;
use App\UserPosition;

class UserPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User Position
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
    }
}
