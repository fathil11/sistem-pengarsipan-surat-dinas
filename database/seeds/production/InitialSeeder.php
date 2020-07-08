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
            "type" => 'Permohonan',
            "code" => 'PRMHN',
            "color" => '#1bcfb4',
        ]);

        MailType::create([
            "type" => 'Pemberitahuan',
            "code" => 'PBRTHN',
            "color" => '#ffd500',
        ]);

        MailType::create([
            "type" => 'Keterangan',
            "code" => 'KTRGN',
            "color" => '#1bcfb4',
        ]);

        MailType::create([
            "type" => 'Undangan',
            "code" => 'UDG',
            "color" => '#c3bdbd',
        ]);

        MailType::create([
            "type" => 'Janji Temu',
            "code" => 'JNJTM',
            "color" => '#c3bdbd',
        ]);
       
        MailType::create([
            "type" => 'Balas Janji Temu',
            "code" => 'BLSJNJTM',
            "color" => '#c3bdbd',
        ]);

        MailType::create([
            "type" => 'Ucapan Terimakasih',
            "code" => 'TRMKSH',
            "color" => '#c3bdbd',
        ]);

        MailType::create([
            "type" => 'Ucapan Duka Cita',
            "code" => 'DKCT',
            "color" => '#c3bdbd',
        ]);

        MailType::create([
            "type" => 'Permohonan Bantuan',
            "code" => 'PMHBNT',
            "color" => '#c3bdbd',
        ]);
        
        MailType::create([
            "type" => 'Pemberian Bantuan',
            "code" => 'PMBBNT',
            "color" => '#c3bdbd',
        ]);

        MailType::create([
            "type" => 'Permohonan Izin',
            "code" => 'PMHIZN',
            "color" => '#c3bdbd',
        ]);

        MailType::create([
            "type" => 'Pemberian Izin',
            "code" => 'PMBIZN',
            "color" => '#c3bdbd',
        ]);

        MailType::create([
            "type" => 'Tugas',
            "code" => 'TGS',
            "color" => '#c3bdbd',
        ]);

        MailType::create([
            "type" => 'Perintah Kerja',
            "code" => 'PRTKRJ',
            "color" => '#c3bdbd',
        ]);

        MailType::create([
            "type" => 'Perjalanan Dinas',
            "code" => 'PRJDNS',
            "color" => '#c3bdbd',
        ]);

        MailType::create([
            "type" => 'Berita Acara',
            "code" => 'BA',
            "color" => '#c3bdbd',
        ]);

        MailType::create([
            "type" => 'Edaran',
            "code" => 'EDRN',
            "color" => '#c3bdbd',
        ]);

        MailType::create([
            "type" => 'Laporan',
            "code" => 'LPRN',
            "color" => '#c3bdbd',
        ]);

        MailType::create([
            "type" => 'Pengantar',
            "code" => 'PNGTR',
            "color" => '#c3bdbd',
        ]);

        MailType::create([
            "type" => 'Referensi',
            "code" => 'RFRNS',
            "color" => '#c3bdbd',
        ]);

        MailType::create([
            "type" => 'Rekomendasi',
            "code" => 'RKMNDS',
            "color" => '#c3bdbd',
        ]);

        MailType::create([
            "type" => 'Peringatan',
            "code" => 'PRNGTN',
            "color" => '#c3bdbd',
        ]);

        MailType::create([
            "type" => 'Panggilan',
            "code" => 'PGLN',
            "color" => '#c3bdbd',
        ]);

        MailType::create([
            "type" => 'Kuasa',
            "code" => 'KSA',
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
            'type' => 'Kesalahan Kepala Surat'
        ]);

        MailCorrectionType::create([
            'type' => 'Kesalahan Penulisan Lampiran'
        ]);

        MailCorrectionType::create([
            'type' => 'Kesalahan Tanggal'
        ]);

        MailCorrectionType::create([
            'type' => 'Kesalahan ALamat'
        ]);

        MailCorrectionType::create([
            'type' => 'Kesalahan Pembuka / Penutup'
        ]);
    }
}
