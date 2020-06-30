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
        $this->call(AdminSeeder::class);
        $this->call(UserDepartmentSeeder::class);
        $this->call(UserPositionDetailSeeder::class);
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
