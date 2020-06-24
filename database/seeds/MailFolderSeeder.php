<?php

use Illuminate\Database\Seeder;
use App\MailFolder;

class MailFolderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MailFolder::create([
            'folder' => 'keuangan'
        ]);

        MailFolder::create([
            'folder' => 'pengadaan'
        ]);

        MailFolder::create([
            'folder' => 'laporan perjalanan'
        ]);

        MailFolder::create([
            'folder' => 'pembangunan'
        ]);

        MailFolder::create([
            'folder' => 'aspirasi'
        ]);
    }
}
