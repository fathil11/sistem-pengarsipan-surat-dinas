<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

use Carbon\Carbon;

use App\User;

use App\Mail;
use App\MailLog;
use App\MailTransaction;
use App\MailVersion;

class MailInTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /** @test */
    public function a_mail_in_can_be_added()
    {
        $this->seed();

        $user = User::withPosition('Kepala TU')->first();
        $this->actingAs($user);

        $this->withoutExceptionHandling();

        $response = $this->storeMailIn();

        $response->assertOk();

        $this->assertDatabaseHas('mails', [
            'id' => Mail::all()->last()->id,
            'mail_folder_id' => 1,
            'mail_type_id' => 1,
            'mail_reference_id' => 2,
            'mail_priority_id' => 1
        ]);

        $this->assertDatabaseHas('mail_versions', [
            'id' => MailVersion::all()->last()->id,
            'mail_id' => Mail::all()->last()->id,
        ]);

        $this->assertDatabaseHas('mail_transactions', [
            'id' => MailTransaction::all()->last()->id,
            'mail_version_id' => MailVersion::all()->last()->id,
            'user_id' => User::withPosition('Kepala TU')->first()->id,
            'target_user_id' => User::withPosition('Sekretaris')->first()->id,
            'type'=> 'create'
        ]);

        $this->assertDatabaseHas('mail_logs', [
            'id' => MailLog::all()->last()->id,
            'mail_transaction_id' => MailTransaction::all()->last()->id,
            'log'=> 'send'
        ]);

    }

    /** @test */
    public function a_mail_in_can_be_updated()
    {
        $this->seed();

        $user = User::withPosition('Kepala TU')->first();
        $this->actingAs($user);

        $this->withoutExceptionHandling();

        $this->storeMailIn();

        $response = $this->patch('/test/surat/masuk/11', [
            'directory_code' => 'udg-003',
            'code' => 'rs-udg-003',
            'title' => 'undangan seminar kesehatan',
            'origin' => 'Universitas Melawi',
            'mail_folder_id' => 1,
            'mail_type_id' => 1,
            'mail_reference_id' => 3,
            'mail_priority_id' => 1,
            'mail_created_at' => Carbon::now(),
        ]);

        $response->assertOk();

        $this->assertDatabaseHas('mails', [
            'id' => Mail::all()->last()->id,
            'directory_code' => 'udg-003',
            'code' => 'rs-udg-003',
            'mail_folder_id' => 1,
            'mail_type_id' => 1,
            'mail_reference_id' => 3,
            'mail_priority_id' => 1
        ]);

        $this->assertDatabaseHas('mail_versions', [
            'id' => MailVersion::all()->last()->id,
            'mail_id' => Mail::all()->last()->id,
        ]);

        $this->assertDatabaseHas('mail_transactions', [
            'id' => MailTransaction::all()->last()->id,
            'mail_version_id' => MailVersion::all()->last()->id,
            'user_id' => User::withPosition('Kepala TU')->first()->id,
            'target_user_id' => User::withPosition('Sekretaris')->first()->id,
            'type'=> 'create'
        ]);

        $this->assertDatabaseHas('mail_logs', [
            'id' => MailLog::all()->last()->id,
            'mail_transaction_id' => MailTransaction::all()->last()->id,
            'log'=> 'send'
        ]);
    }

    /** @test */
    public function a_mail_in_can_be_updated_with_file()
    {
        $this->seed();

        $user = User::withPosition('Kepala TU')->first();
        $this->actingAs($user);

        $this->withoutExceptionHandling();

        $this->storeMailIn();

        $response = $this->patch('/test/surat/masuk/11', [
            'directory_code' => 'udg-003',
            'code' => 'rs-udg-003',
            'title' => 'undangan seminar kesehatan',
            'origin' => 'Universitas Melawi',
            'mail_folder_id' => 1,
            'mail_type_id' => 1,
            'mail_reference_id' => 3,
            'mail_priority_id' => 1,
            'mail_created_at' => Carbon::now(),

            'file' => UploadedFile::fake()->image('undangan003.jpg')->size(3000),
        ]);

        $response->assertOk();

        $this->assertDatabaseHas('mails', [
            'id' => Mail::all()->last()->id,
            'directory_code' => 'udg-003',
            'code' => 'rs-udg-003',
            'mail_folder_id' => 1,
            'mail_type_id' => 1,
            'mail_reference_id' => 3,
            'mail_priority_id' => 1
        ]);

        $this->assertDatabaseHas('mail_versions', [
            'id' => MailVersion::all()->last()->id,
            'mail_id' => Mail::all()->last()->id,
        ]);

        $this->assertDatabaseHas('mail_transactions', [
            'id' => MailTransaction::all()->last()->id,
            'mail_version_id' => MailVersion::all()->last()->id,
            'user_id' => User::withPosition('Kepala TU')->first()->id,
            'target_user_id' => User::withPosition('Sekretaris')->first()->id,
            'type'=> 'create'
        ]);

        $this->assertDatabaseHas('mail_logs', [
            'id' => MailLog::all()->last()->id,
            'mail_transaction_id' => MailTransaction::all()->last()->id,
            'log'=> 'send'
        ]);
    }

    /** @test */
    public function a_mail_in_can_be_deleted()
    {
        $this->seed('DatabaseSeeder');

        $this->withoutExceptionHandling();

        $response = $this->delete('/test/surat/masuk/1');

        $response->assertOk();
    }

    private function storeMailIn(){
        Storage::fake('documents');
        return $this->post('/test/surat/masuk', [
            'directory_code' => 'udg-002',
            'code' => 'rs-udg-002',
            'title' => 'undangan seminar kesehatan',
            'origin' => 'Universitas Melawi',
            'mail_folder_id' => 1,
            'mail_type_id' => 1,
            'mail_reference_id' => 2,
            'mail_priority_id' => 1,
            'mail_created_at' => Carbon::now(),

            'file' => UploadedFile::fake()->image('undangan002.jpg')->size(3000),
        ]);
    }
}
