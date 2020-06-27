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

class MailInDispositionTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function a_mail_can_create_disposition_after_forwarded()
    {
        $this->seed();

        $user = User::withPosition('Kepala Dinas')->first();
        $this->actingAs($user);

        $this->withoutExceptionHandling();
        $this->storeMailIn();

        $response = $this->post('/test/surat/masuk/11/teruskan', [
            'memo' => 'Mantul',
        ]);

        $response->assertOk();

        $response = $this->post('/test/surat/masuk/11/disposisi', [
            'memo' => 'Perfect',
        ]);

        $response->assertOk();
    }

    /** @test */
    public function a_mail_cant_be_updated_after_has_disposition()
    {
        $this->seed();

        $user = User::withPosition('Kepala Dinas')->first();
        $this->actingAs($user);

        $this->withoutExceptionHandling();

        $this->storeMailIn();
        $response = $this->post('/test/surat/masuk/11/teruskan', [
            'memo' => 'Mantul',
        ]);

        $response->assertOk();

        $response = $this->post('/test/surat/masuk/11/disposisi', [
            'memo' => 'Perfect',
        ]);

        $response->assertOk();

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

    /** @test */
    public function a_mail_cant_create_disposition_if_has_disposition_before()
    {
        $this->seed();

        $user = User::withPosition('Kepala Dinas')->first();
        $this->actingAs($user);

        $this->withoutExceptionHandling();

        $this->storeMailIn();

        $response = $this->post('/test/surat/masuk/11/teruskan', [
            'memo' => 'Mantul',
        ]);

        $response->assertOk();

        $response = $this->post('/test/surat/masuk/11/disposisi', [
            'memo' => 'Perfect',
        ]);

        $response->assertOk();

        $response = $this->post('/test/surat/masuk/11/disposisi', [
            'memo' => 'Perfect',
        ]);

        $response->assertRedirect();
    }

    /** @test */
    public function a_mail_cant_create_disposition_before_been_forwarded()
    {
        $this->seed();

        $user = User::withPosition('Kepala Dinas')->first();
        $this->actingAs($user);

        $this->withoutExceptionHandling();

        $this->storeMailIn();

        $response = $this->post('/test/surat/masuk/11/disposisi', [
            'memo' => 'Perfect',
        ]);

        $response->assertRedirect();
    }

    private function storeMailIn()
    {
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
