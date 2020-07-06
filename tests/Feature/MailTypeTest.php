<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\MailType;

class MailTypeTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function a_mail_type_can_added()
    {
        $response = $this->post('/test/pengguna/surat/jenis', [
            'type' => 'undangan',
            'code' => 'udg',
            'color' => 'kuning',
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function mail_type_with_type_less_than_3_cant_added()
    {
        $response = $this->post('/test/pengguna/surat/jenis', [
            'type' => 'aa',
            'code' => 'udg',
            'color' => 'kuning',
        ]);

        $response->assertRedirect();
    }

    /** @test */
    public function mail_type_with_code_less_than_2_cant_added()
    {
        $response = $this->post('/test/pengguna/surat/jenis', [
            'type' => 'undangan',
            'code' => 'a',
            'color' => 'kuning',
        ]);

        $response->assertRedirect();
    }

    /** @test */
    public function mail_type_with_color_less_than_3_cant_added()
    {
        $response = $this->post('/test/pengguna/surat/jenis', [
            'type' => 'undangan',
            'code' => 'udg',
            'color' => 'aa',
        ]);

        $response->assertRedirect();
    }

    /** @test */
    public function a_mail_type_can_be_updated()
    {
        $this->post('/test/pengguna/surat/jenis', [
            'type' => 'undangan',
            'code' => 'udg',
            'color' => 'kuning',
        ]);

        $response = $this->patch('/test/pengguna/surat/jenis/1', [
            'type' => 'undangan',
            'code' => 'ug',
            'color' => 'kuning',
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function a_mail_type_can_be_deleted()
    {
        $this->post('/test/pengguna/surat/jenis', [
            'type' => 'undangan',
            'code' => 'udg',
            'color' => 'kuning',
        ]);

        $response = $this->delete('/test/pengguna/surat/jenis/1');

        $response->assertStatus(200);
    }
}
