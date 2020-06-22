<?php

use Illuminate\Database\Seeder;
use App\MailPriority;

class MailPrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MailPriority::create([
            "type" => 'cepat',
            "code" => 'cpt',
            "color" => 'hijau',
        ]);

        MailPriority::create([
            "type" => 'segera',
            "code" => 'sgr',
            "color" => 'kuning',
        ]);

        MailPriority::create([
            "type" => 'sangat segera',
            "code" => 'ssgr',
            "color" => 'merah',
        ]);
    }
}
