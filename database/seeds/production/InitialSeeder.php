<?php

namespace Seed\Production;

use Illuminate\Database\Seeder;
use App\MailCorrectionType;
use App\MailReference;
use App\MailPriority;
use App\MailFolder;
use App\MailType;

class InitialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Mail Type
        MailType::create([
            "type" => 'Undangan',
            "code" => 'UDG',
            "color" => '#ffd500',
        ]);

        MailType::create([
            "type" => 'Permohonan',
            "code" => 'PRMHN',
            "color" => '#1bcfb4',
        ]);

        MailType::create([
            "type" => 'Peminjaman',
            "code" => 'PMNJMN',
            "color" => '#c3bdbd',
        ]);


        // Mail Reference
        MailReference::create([
            "type" => 'Umum',
            "code" => 'UM',
            "color" => '#fe5678',
        ]);

        MailReference::create([
            "type" => 'Tertutup',
            "code" => 'TRTP',
            "color" => '#ffd500',
        ]);

        MailReference::create([
            "type" => 'Rahasia',
            "code" => 'RHS',
            "color" => '#1bcfb4',
        ]);


        // Mail Priority
        MailPriority::create([
            "type" => 'Biasa',
            "code" => 'BS',
            "color" => '#1bcfb4',
        ]);

        MailPriority::create([
            "type" => 'Segera',
            "code" => 'SGR',
            "color" => '#ffd500',
        ]);

        MailPriority::create([
            "type" => 'Mendesak',
            "code" => 'MNDSK',
            "color" => '#fe5678',
        ]);


        // Mail Folder
        MailFolder::create([
            'folder' => 'Keuangan'
        ]);

        MailFolder::create([
            'folder' => 'Pengadaan'
        ]);

        MailFolder::create([
            'folder' => 'Laporan Perjalanan'
        ]);

        MailFolder::create([
            'folder' => 'Pembangunan'
        ]);

        MailFolder::create([
            'folder' => 'Aspirasi'
        ]);


        // Mail Correction Type
        MailCorrectionType::create([
            'type' => 'Kesalahan KOP'
        ]);

        MailCorrectionType::create([
            'type' => 'Kesalahan Perihal'
        ]);

        MailCorrectionType::create([
            'type' => 'Kesalahan Nama'
        ]);
    }
}
