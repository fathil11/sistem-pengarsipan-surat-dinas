<?php

use Illuminate\Database\Seeder;

use App\Mail;
use App\MailFile;
use App\MailVersion;
use App\MailTransaction;

use Carbon\Carbon;

class MailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Mail 1
        $mail[0] = Mail::create([
            'kind' => 'in',
            'directory_code' => 'udg-001',
            'code' => 'rs-udg-001',
            'title' => 'undangan rapat dinas',
            'origin' => 'pemerintah provinsi',
            'mail_folder_id' => '1',
            'mail_type_id' => '1',
            'mail_reference_id' => '2',
            'mail_priority_id' => '1',
            'mail_created_at' => Carbon::now(),
        ]);

        $mail_version[0] = MailVersion::create([
            'mail_id' => $mail[0]->id,
            'version' => '1',
        ]);

        MailFile::create([
            'mail_version_id' => $mail_version[0]->id,
            'original_name' => 'udg-001',
            'directory_name' => 'rs-udg-001',
            'type' => 'jpg'
        ]);

        MailTransaction::create([
            'mail_version_id' => '1',
            'user_id' => '8',
            'target_user_id' => '4',
            'type' => 'create',
        ]);

        MailTransaction::create([
            'mail_version_id' => '1',
            'user_id' => '8',
            'target_user_id' => '9',
            'type' => 'create',
        ]);


        //Mail 2
        $mail[1] = Mail::create([
            'kind' => 'in',
            'directory_code' => 'mhn-001',
            'code' => 'rs-mhn-001',
            'title' => 'permohonan obat-obatan',
            'origin' => 'puskesmas',
            'mail_folder_id' => '2',
            'mail_type_id' => '2',
            'mail_reference_id' => '2',
            'mail_priority_id' => '1',
            'mail_created_at' => Carbon::now(),
        ]);

        $mail_version[1] = MailVersion::create([
            'mail_id' => $mail[1]->id,
            'version' => '1',
        ]);

        MailFile::create([
            'mail_version_id' => $mail_version[1]->id,
            'original_name' => 'mhn-001',
            'directory_name' => 'rs-mhn-001',
            'type' => 'jpg'
        ]);

        MailTransaction::create([
            'mail_version_id' => '2',
            'user_id' => '8',
            'target_user_id' => '4',
            'type' => 'create',
        ]);

        MailTransaction::create([
            'mail_version_id' => '2',
            'user_id' => '8',
            'target_user_id' => '9',
            'type' => 'create',
        ]);

        $mail_version[1] = MailVersion::create([
            'mail_id' => $mail[1]->id,
            'version' => '2',
        ]);

        MailFile::create([
            'mail_version_id' => $mail_version[1]->id,
            'original_name' => 'mhn-001',
            'directory_name' => 'rs-mhn-001',
            'type' => 'jpg'
        ]);

        MailTransaction::create([
            'mail_version_id' => '3',
            'user_id' => '8',
            'target_user_id' => '4',
            'type' => 'create',
        ]);

        MailTransaction::create([
            'mail_version_id' => '3',
            'user_id' => '8',
            'target_user_id' => '9',
            'type' => 'create',
        ]);
    }
}
