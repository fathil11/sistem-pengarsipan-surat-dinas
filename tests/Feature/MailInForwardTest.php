<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Carbon\Carbon;

use App\User;
use App\UserPosition;

use App\Mail;
use App\MailLog;
use App\MailTransaction;
use App\MailVersion;
use App\MailMemo;

class MailInForwardTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function a_mail_can_be_forwarded()
    {
        $this->seed();

        $user = User::withPosition('Sekretaris')->first();
        $this->actingAs($user);

        $this->withoutExceptionHandling();

        $this->storeMailIn();

        $response = $this->post('/test/surat/masuk/11/teruskan', [
            'memo' => 'Mantul',
        ]);

        $response->assertOk();

        $this->assertDatabaseHas('mail_transactions', [
            'id' => MailTransaction::all()->last()->id,
            'mail_version_id' => MailVersion::all()->last()->id,
            'user_id' => User::withPosition('Sekretaris')->first()->id,
            'target_user_id' => User::withPosition('Kepala Dinas')->first()->id,
            'type'=> 'memo'
        ]);

        $this->assertDatabaseHas('mail_memos', [
            'id' => MailMemo::all()->last()->id,
            'mail_transaction_id' => MailTransaction::all()->last()->id,
            'memo' => 'Mantul',
        ]);

        $this->assertDatabaseHas('mail_logs', [
            'id' => MailLog::all()->last()->id,
            'mail_transaction_id' => MailTransaction::all()->last()->id,
            'log'=> 'send'
        ]);
    }

    /** @test */
    public function a_mail_cant_be_forwarded_if_has_memo_before()
    {
        $this->seed();

        $user = User::withPosition('Sekretaris')->first();
        $this->actingAs($user);

        $this->withoutExceptionHandling();

        $this->storeMailIn();

        $this->post('/test/surat/masuk/11/teruskan', [
            'memo' => 'Mantul',
        ]);

        $response = $this->post('/test/surat/masuk/11/teruskan', [
            'memo' => 'Mantul',
        ]);

        $response->assertRedirect();
    }
    /** @test */
    public function a_mail_cant_be_updated_after_forwarded()
    {
        $this->seed();

        $user = User::withPosition('Sekretaris')->first();
        $this->actingAs($user);

        $this->withoutExceptionHandling();

        $this->storeMailIn();

        $this->post('/test/surat/masuk/11/teruskan', [
            'memo' => 'Mantul',
        ]);

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

        $response->assertRedirect();
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
