<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserDepartmentSeeder::class);
        $this->call(UserPositionSeeder::class);
        $this->call(UserPositionDetailSeeder::class);
        $this->call(UserSeeder::class);
    }
}
