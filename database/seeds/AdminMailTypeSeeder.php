<?php

use Illuminate\Database\Seeder;
use App\MailType;

class AdminMailTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MailType::create([
            "type" => 'undangan',
            "code" => 'udg',
            "color" => 'kuning',
        ]);

        MailType::create([
            "type" => 'permohonan',
            "code" => 'mhn',
            "color" => 'hijau',
        ]);

        MailType::create([
            "type" => 'pengantar',
            "code" => 'atr',
            "color" => 'abu-abu',
        ]);
    }
}
