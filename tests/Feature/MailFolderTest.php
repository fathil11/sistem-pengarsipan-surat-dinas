<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MailFolderTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function a_mail_folder_can_added()
    {
        $response = $this->post('/test/pengguna/surat/berkas', [
            'folder' => 'undangan',
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function a_mail_folder_with_folder_less_than_3_cant_added()
    {
        $response = $this->post('/test/pengguna/surat/berkas', [
            'folder' => 'un',
        ]);

        $response->assertRedirect();
    }

    /** @test */
    public function a_mail_folder_can_be_updated()
    {
        $this->post('/test/pengguna/surat/berkas', [
            'folder' => 'undangan',
        ]);

        $response = $this->patch('/test/pengguna/surat/berkas/1', [
            'folder' => 'keluhan',
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function a_mail_folder_can_be_deleted()
    {
        $this->post('/test/pengguna/surat/berkas', [
            'folder' => 'undangan',
        ]);

        $response = $this->delete('/test/pengguna/surat/berkas/1');

        $response->assertStatus(200);
    }
}
