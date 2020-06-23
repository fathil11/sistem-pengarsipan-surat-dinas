<?php

namespace Tests\Feature;

use App\User;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MailOutTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function a_mail_out_can_adeed()
    {
        $this->seed();
        $this->actingAs(User::find(1));
        $response = $this->createMailOut();

        $response->assertOk();

        $this->assertDatabaseHas('mails', [
            'id' => 3,
            'mail_folder_id' => 1,
            'mail_type_id' => 1,
            'mail_reference_id' => 1,
            'mail_priority_id' => 1
        ]);

        $this->assertDatabaseHas('mail_versions', [
            'id' => 4,
            'mail_id' => 3,
            'version'=> 0
        ]);

        $this->assertDatabaseHas('mail_logs', [
            'id' => 1,
            'mail_transaction_id' => 7,
            'log'=> 'delivered'
        ]);
    }

    private function createMailOut()
    {
        Storage::fake('documents');
        return $this->post('/test/surat/keluar', [
            // 'directory_code' => 'udg-002',
            // 'code' => 'rs-udg-002',
            'title' => 'undangan seminar kesehatan',
            'mail_folder_id' => 1,
            'mail_type_id' => 1,
            'mail_reference_id' => 1,
            'mail_priority_id' => 1,
            'mail_created_at' => Carbon::now(),
            'file' => UploadedFile::fake()->image('undangan002.jpg')->size(4000),
        ]);
    }
}
