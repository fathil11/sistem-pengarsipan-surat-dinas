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
        // $this->call(UserSeeder::class);
        $this->call(AdminMailPrioritySeeder::class);
        $this->call(AdminMailReferenceSeeder::class);
        $this->call(AdminMailTypeSeeder::class);
        $this->call(AdminMailFolderSeeder::class);

        $this->call(MailSeeder::class);
    }
}
