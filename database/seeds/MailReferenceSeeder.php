<?php

use Illuminate\Database\Seeder;
use App\MailReference;

class MailReferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MailReference::create([
            "type" => 'rahasia',
            "code" => 'rhs',
            "color" => '#fe5678',
        ]);

        MailReference::create([
            "type" => 'resmi',
            "code" => 'rsm',
            "color" => '#ffd500',
        ]);

        MailReference::create([
            "type" => 'penting',
            "code" => 'ptg',
            "color" => '#1bcfb4',
        ]);
    }
}
