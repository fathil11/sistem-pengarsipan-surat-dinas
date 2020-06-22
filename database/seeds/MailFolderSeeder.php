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
            'folder' => 'undangan'
        ]);

        MailFolder::create([
            'folder' => 'permohonan'
        ]);

        MailFolder::create([
            'folder' => 'peminjaman'
        ]);

        MailFolder::create([
            'folder' => 'pengantar'
        ]);
    }
}
