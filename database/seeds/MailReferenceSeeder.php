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
            "color" => 'merah',
        ]);

        MailReference::create([
            "type" => 'resmi',
            "code" => 'rsm',
            "color" => 'kuning',
        ]);

        MailReference::create([
            "type" => 'penting',
            "code" => 'ptg',
            "color" => 'hijau',
        ]);
    }
}
