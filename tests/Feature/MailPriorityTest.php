<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MailPriorityTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function a_mail_priority_can_added()
    {
        $response = $this->post('/test/pengguna/surat/tipe', [
            'type' => 'cepat',
            'code' => 'cpt',
            'color' => 'hijau',
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function mail_priority_with_type_less_than_3_cant_added()
    {
        $response = $this->post('/test/pengguna/surat/tipe', [
            'type' => 'cc',
            'code' => 'cpt',
            'color' => 'hijau',
        ]);

        $response->assertRedirect();
    }

    /** @test */
    public function mail_priority_with_code_less_than_2_cant_added()
    {
        $response = $this->post('/test/pengguna/surat/tipe', [
            'type' => 'cepat',
            'code' => 'c',
            'color' => 'hijau',
        ]);

        $response->assertRedirect();
    }

    /** @test */
    public function mail_priority_with_color_less_than_3_cant_added()
    {
        $response = $this->post('/test/pengguna/surat/tipe', [
            'type' => 'undangan',
            'code' => 'cc',
            'color' => 'aa',
        ]);

        $response->assertRedirect();
    }
}
