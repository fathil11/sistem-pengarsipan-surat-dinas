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
        // User Seeder
        $this->call(UserDepartmentSeeder::class);
        $this->call(UserPositionSeeder::class);
        $this->call(UserPositionDetailSeeder::class);
        $this->call(UserSeeder::class);

        // Mail Seeder
        $this->call(MailPrioritySeeder::class);
        $this->call(MailReferenceSeeder::class);
        $this->call(MailTypeSeeder::class);
        $this->call(MailFolderSeeder::class);
        $this->call(MailSeeder::class);
    }
}
