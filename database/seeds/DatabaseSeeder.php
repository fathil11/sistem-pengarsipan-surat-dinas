<?php

use Illuminate\Database\Seeder;
use Seed\Production\InitialSeeder;
use Seed\Production\UserDepartmentSeeder;
use Seed\Production\UserPositionDetailSeeder;
use Seed\Production\UserPositionSeeder;
use Seed\Production\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /** Production Seeder */
        $this->call(InitialSeeder::class);
        $this->call(UserPositionSeeder::class);
        $this->call(UserDepartmentSeeder::class);
        $this->call(UserPositionDetailSeeder::class);
        $this->call(UserSeeder::class);


        /** Testing Seeder */
        // User Seeder
        // $this->call(UserPositionSeeder::class);
        // $this->call(UserSeeder::class);

        // Mail Seeder
        // $this->call(MailPrioritySeeder::class);
        // $this->call(MailReferenceSeeder::class);
        // $this->call(MailTypeSeeder::class);
        // $this->call(MailFolderSeeder::class);
        // $this->call(MailSeeder::class);
    }
}
