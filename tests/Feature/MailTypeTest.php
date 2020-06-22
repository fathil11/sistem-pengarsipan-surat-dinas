<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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
        $response = $this->post('/test/pengguna/surat/tipe', [
            'type' => 'undangan',
            'code' => 'udg',
            'color' => 'kuning',
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function mail_type_with_type_less_than_3_cant_added()
    {
        $response = $this->post('/test/pengguna/surat/tipe', [
            'type' => 'aa',
            'code' => 'udg',
            'color' => 'kuning',
        ]);

        $response->assertRedirect();
    }

    /** @test */
    public function mail_type_with_code_less_than_2_cant_added()
    {
        $response = $this->post('/test/pengguna/surat/tipe', [
            'type' => 'undangan',
            'code' => 'a',
            'color' => 'kuning',
        ]);

        $response->assertRedirect();
    }

    /** @test */
    public function mail_type_with_color_less_than_3_cant_added()
    {
        $response = $this->post('/test/pengguna/surat/tipe', [
            'type' => 'undangan',
            'code' => 'udg',
            'color' => 'aa',
        ]);

        $response->assertRedirect();
    }
}
