<?php

namespace Seed\Production;

use Illuminate\Database\Seeder;
use App\UserDepartment;

class UserDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User Department
        UserDepartment::create([
            'department' => 'Kesehatan Masyarakat',
            'department_abbreviation' => 'KESMAS'
        ]);

        UserDepartment::create([
            'department' => 'Pengendalian Penyakit',
            'department_abbreviation' => 'P2'
        ]);

        UserDepartment::create([
            'department' => 'Sumber Daya Kesehatan',
            'department_abbreviation' => 'SDK'
        ]);
    }
}
