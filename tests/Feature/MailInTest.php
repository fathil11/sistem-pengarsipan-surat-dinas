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
}
