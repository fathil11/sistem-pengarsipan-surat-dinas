<?php

namespace Tests\Feature;

use App\Mail;
use App\MailFolder;
use App\User;
use App\MailLog;
use App\MailTransaction;
use Carbon\Carbon;
use Tests\TestCase;
use App\MailVersion;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MailOutTest extends TestCase
{
    // use RefreshDatabase;
    // /**
    //  * A basic feature test example.
    //  *
    //  * @return void
    //  */

    // /** @test */
    // public function a_mail_out_can_adeed_by_admin()
    // {
    //     $this->seed();

    //     $user = User::withPosition('Admin')->first();
    //     $this->actingAs($user);

    //     $response = $this->createMailOut();

    //     $response->assertOk();

    //     $this->assertDatabaseHas('mails', [
    //         'id' => Mail::all()->last()->id,
    //         'mail_folder_id' => 1,
    //         'mail_type_id' => 1,
    //         'mail_reference_id' => 1,
    //         'mail_priority_id' => 1
    //     ]);

    //     $this->assertDatabaseHas('mail_versions', [
    //         'id' => MailVersion::all()->last()->id,
    //         'mail_id' => 3,
    //         'version'=> 0
    //     ]);

    //     $this->assertDatabaseHas('mail_transactions', [
    //         'id' => MailTransaction::all()->last()->id,
    //         'mail_version_id' => MailVersion::all()->last()->id,
    //         'user_id' => User::withPosition('Admin')->first()->id,
    //         'target_user_id' => User::withPosition('Kepala TU')->first()->id,
    //         'type'=> 'create'
    //     ]);

    //     $this->assertDatabaseHas('mail_logs', [
    //         'id' => MailLog::all()->last()->id,
    //         'mail_transaction_id' => 7,
    //         'log'=> 'sent'
    //     ]);
    // }

    // /** @test */
    // public function a_mail_out_can_adeed_by_kepala_dinas()
    // {
    //     $this->seed();

    //     $user = User::withPosition('Kepala Dinas')->first();
    //     $this->actingAs($user);

    //     $response = $this->createMailOut();

    //     $response->assertOk();

    //     $this->assertDatabaseHas('mails', [
    //         'id' => Mail::all()->last()->id,
    //         'mail_folder_id' => 1,
    //         'mail_type_id' => 1,
    //         'mail_reference_id' => 1,
    //         'mail_priority_id' => 1
    //     ]);

    //     $this->assertDatabaseHas('mail_versions', [
    //         'id' => MailVersion::all()->last()->id,
    //         'mail_id' => Mail::all()->last()->id,
    //         'version'=> 0
    //     ]);

    //     $this->assertDatabaseHas('mail_transactions', [
    //         'id' => MailTransaction::all()->last()->id,
    //         'mail_version_id' => MailVersion::all()->last()->id,
    //         'user_id' => User::withPosition('Kepala Dinas')->first()->id,
    //         'target_user_id' => User::withPosition('Kepala TU')->first()->id,
    //         'type'=> 'create'
    //     ]);

    //     $this->assertDatabaseHas('mail_logs', [
    //         'id' => MailLog::all()->last()->id,
    //         'mail_transaction_id' => MailTransaction::all()->last()->id,
    //         'log'=> 'sent'
    //     ]);
    // }

    // /** @test */
    // public function a_mail_out_can_adeed_by_kepala_bidang()
    // {
    //     $this->seed();

    //     $user = User::withPosition('Kepala Bidang')->first();
    //     $this->actingAs($user);

    //     $response = $this->createMailOut();

    //     $response->assertOk();

    //     $this->assertDatabaseHas('mails', [
    //         'id' => Mail::all()->last()->id,
    //         'mail_folder_id' => 1,
    //         'mail_type_id' => 1,
    //         'mail_reference_id' => 1,
    //         'mail_priority_id' => 1
    //     ]);

    //     $this->assertDatabaseHas('mail_versions', [
    //         'id' => MailVersion::all()->last()->id,
    //         'mail_id' => Mail::all()->last()->id,
    //         'version'=> 0
    //     ]);

    //     $this->assertDatabaseHas('mail_transactions', [
    //         'id' => MailTransaction::all()->last()->id,
    //         'mail_version_id' => MailVersion::all()->last()->id,
    //         'user_id' => User::withPosition('Kepala Bidang')->first()->id,
    //         'target_user_id' => User::withPosition('Sekretaris')->first()->id,
    //         'type'=> 'create'
    //     ]);

    //     $this->assertDatabaseHas('mail_logs', [
    //         'id' => MailLog::all()->last()->id,
    //         'mail_transaction_id' => MailTransaction::all()->last()->id,
    //         'log'=> 'sent'
    //     ]);
    // }

    // /** @test */
    // public function a_mail_out_can_adeed_by_kepala_seksie()
    // {
    //     $this->seed();

    //     $user = User::withPosition('Kepala Bidang')->first();
    //     $this->actingAs($user);

    //     $response = $this->createMailOut();

    //     $response->assertOk();

    //     $this->assertDatabaseHas('mails', [
    //         'id' => Mail::all()->last()->id,
    //         'mail_folder_id' => 1,
    //         'mail_type_id' => 1,
    //         'mail_reference_id' => 1,
    //         'mail_priority_id' => 1
    //     ]);

    //     $this->assertDatabaseHas('mail_versions', [
    //         'id' => MailVersion::all()->last()->id,
    //         'mail_id' => Mail::all()->last()->id,
    //         'version'=> 0
    //     ]);

    //     $this->assertDatabaseHas('mail_transactions', [
    //         'id' => MailTransaction::all()->last()->id,
    //         'mail_version_id' => MailVersion::all()->last()->id,
    //         'user_id' => User::withPosition('Kepala Bidang')->first()->id,
    //         'target_user_id' => User::withPosition('Sekretaris')->first()->id,
    //         'type'=> 'create'
    //     ]);

    //     $this->assertDatabaseHas('mail_logs', [
    //         'id' => MailLog::all()->last()->id,
    //         'mail_transaction_id' => MailTransaction::all()->last()->id,
    //         'log'=> 'sent'
    //     ]);
    // }

    // private function createMailOut()
    // {
    //     Storage::fake('documents');
    //     return $this->post('/test/surat/keluar', [
    //         // 'directory_code' => 'udg-002',
    //         // 'code' => 'rs-udg-002',
    //         'title' => 'undangan seminar kesehatan',
    //         'mail_folder_id' => 1,
    //         'mail_type_id' => 1,
    //         'mail_reference_id' => 1,
    //         'mail_priority_id' => 1,
    //         'mail_created_at' => Carbon::now(),
    //         'file' => UploadedFile::fake()->image('undangan002.jpg')->size(4000),
    //     ]);
    // }
}
