<?php

use Illuminate\Database\Seeder;
use App\MailType;

class MailTypeSeeder extends Seeder
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
            "color" => '#ffd500',
        ]);

        MailType::create([
            "type" => 'permohonan',
            "code" => 'mhn',
            "color" => '#1bcfb4',
        ]);

        MailType::create([
            "type" => 'pengantar',
            "code" => 'atr',
            "color" => '#c3bdbd',
        ]);
    }
}
