<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Carbon\Carbon;

class MailInTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_mail_in_can_be_added()
    {
        $this->seed('DatabaseSeeder');

        $this->withoutExceptionHandling();

        Storage::fake('documents');


        $response = $this->post('/test/surat/masuk/buat', [
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

        $response->assertOk();
    }

    /** @test */
    public function a_mail_in_cant_be_added_if_file_doesnt_exists()
    {
        $this->seed('DatabaseSeeder');

        $this->withoutExceptionHandling();

        Storage::fake('documents');


        $response = $this->post('/test/surat/masuk/buat', [
            'directory_code' => 'udg-002',
            'code' => 'rs-udg-002',
            'title' => 'undangan seminar kesehatan',
            'origin' => 'Universitas Melawi',
            'mail_folder_id' => 1,
            'mail_type_id' => 11,
            'mail_reference_id' => 2,
            'mail_priority_id' => 1,
            'mail_created_at' => Carbon::now(),

            'file' => UploadedFile::fake()->image('undangan002.jpg')->size(3000),
        ]);

        $response->assertRedirect();
    }

    /** @test */
    public function a_mail_in_can_be_updated()
    {
        $this->seed('DatabaseSeeder');

        $this->withoutExceptionHandling();

        $response = $this->patch('/test/surat/masuk/1/update', [
            'directory_code' => 'udg-002',
            'code' => 'rs-udg-002',
            'title' => 'undangan seminar kesehatan',
            'origin' => 'Universitas Melawi',
            'mail_folder_id' => 1,
            'mail_type_id' => 1,
            'mail_reference_id' => 2,
            'mail_priority_id' => 1,
            'mail_created_at' => Carbon::now(),
        ]);

        $response->assertOk();
    }
}
