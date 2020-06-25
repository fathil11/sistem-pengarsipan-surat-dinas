<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MailCorrectionTypeTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function a_mail_correction_type_can_added()
    {
        $response = $this->post('/test/pengguna/surat/tipe-koreksi', [
            'type' => 'kesalahan penulisan',
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function a_mail_correction_type_with_correction_type_less_than_3_cant_added()
    {
        $response = $this->post('/test/pengguna/surat/tipe-koreksi', [
            'type' => 'sp',
        ]);

        $response->assertRedirect();
    }

    /** @test */
    public function a_mail_correction_type_can_be_updated()
    {
        $this->post('/test/pengguna/surat/tipe-koreksi', [
            'type' => 'kesalahan penulisan',
        ]);

        $response = $this->patch('/test/pengguna/surat/tipe-koreksi/1', [
            'type' => 'typo',
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function a_mail_correction_type_can_be_deleted()
    {
        $this->post('/test/pengguna/surat/tipe-koreksi', [
            'type' => 'kesalahan penulisan',
        ]);

        $response = $this->delete('/test/pengguna/surat/tipe-koreksi/1');

        $response->assertStatus(200);
    }
}
