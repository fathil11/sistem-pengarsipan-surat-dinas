<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MailReferenceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function a_mail_reference_can_added()
    {
        $response = $this->post('/test/pengguna/surat/sifat', [
            'type' => 'rahasia',
            'code' => 'rhs',
            'color' => 'merah',
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function mail_reference_with_type_less_than_3_cant_added()
    {
        $response = $this->post('/test/pengguna/surat/sifat', [
            'type' => 'r',
            'code' => 'rhs',
            'color' => 'merah',
        ]);

        $response->assertRedirect();
    }

    /** @test */
    public function mail_reference_with_code_less_than_2_cant_added()
    {
        $response = $this->post('/test/pengguna/surat/sifat', [
            'type' => 'rahasia',
            'code' => 'r',
            'color' => 'merah',
        ]);

        $response->assertRedirect();
    }

    /** @test */
    public function mail_reference_with_color_less_than_3_cant_added()
    {
        $response = $this->post('/test/pengguna/surat/sifat', [
            'type' => 'rahasia',
            'code' => 'rhs',
            'color' => 'me',
        ]);

        $response->assertRedirect();
    }

    /** @test */
    public function a_mail_reference_can_be_updated()
    {
        $this->post('/test/pengguna/surat/sifat', [
            'type' => 'rahasia',
            'code' => 'rhs',
            'color' => 'merah',
        ]);

        $response = $this->patch('/test/pengguna/surat/sifat/1', [
            'type' => 'rahasia',
            'code' => 'rhs',
            'color' => 'merah',
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function a_mail_reference_can_be_deleted()
    {
        $this->post('/test/pengguna/surat/sifat', [
            'type' => 'rahasia',
            'code' => 'rhs',
            'color' => 'merah',
        ]);

        $response = $this->delete('/test/pengguna/surat/sifat/1');

        $response->assertStatus(200);
    }
}
