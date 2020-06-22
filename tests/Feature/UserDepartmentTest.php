<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserDepartmentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function a_department_can_added()
    {
        $response = $this->post('/test/pengguna/bidang', [
            'department' => 'Ilmu Pengetahuan dan Teknologi',
            'department_abbreviation' => 'IPTEK',
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function department_with_character_less_than_3_cant_added()
    {
        $response = $this->post('/test/pengguna/bidang', [
            'department' => 'aa',
            'department_abbreviation' => 'IPTEK',
        ]);

        $response->assertRedirect();
    }

    /** @test */
    public function department_abbreviation_with_character_less_than_2_cant_added()
    {
        $response = $this->post('/test/pengguna/bidang', [
            'department' => 'Ilmu Pengetahuan dan Teknologi',
            'department_abbreviation' => 'I',
        ]);

        $response->assertRedirect();
    }
}
