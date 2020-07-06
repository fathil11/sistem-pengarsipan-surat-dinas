<?php

use App\MailCorrectionType;
use App\MailType;
use App\MailFolder;
use App\MailPriority;
use App\UserPosition;
use App\MailReference;
use App\UserDepartment;
use Illuminate\Database\Seeder;

class InitialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User Position
        UserPosition::create([
            'position' => 'Admin',
            'role' => 'admin',
        ]);
        UserPosition::create([
            'position' => 'Kepala Dinas',
            'role' => 'kepala_dinas',
        ]);
        UserPosition::create([
            'position' => 'Sekretaris',
            'role' => 'sekretaris',
        ]);
        UserPosition::create([
            'position' => 'Kepala TU',
            'role' => 'kepala_tu',
        ]);
        UserPosition::create([
            'position' => 'Kepala Bidang',
            'role' => 'kepala_bidang',
        ]);
        UserPosition::create([
            'position' => 'Kepala Seksie',
            'role' => 'kepala_seksie',
        ]);


        // User Department
        UserDepartment::create([
            'department' => 'Bidang Satu',
            'department_abbreviation' => 'BID1'
        ]);

        UserDepartment::create([
            'department' => 'Bidang Dua',
            'department_abbreviation' => 'BID2'
        ]);

        UserDepartment::create([
            'department' => 'Bidang Tiga',
            'department_abbreviation' => 'BID3'
        ]);


        // User Position Detail
        DB::table('user_position_details')->insert([
            'position_detail' => 'Unknown'
        ]);

        DB::table('user_position_details')->insert([
            'position_detail' => 'Anggota 1'
        ]);

        DB::table('user_position_details')->insert([
            'position_detail' => 'Anggota 2'
        ]);

        DB::table('user_position_details')->insert([
            'position_detail' => 'Anggota 3'
        ]);


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
