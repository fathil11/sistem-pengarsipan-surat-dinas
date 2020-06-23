<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserPositionDetailTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function a_position_detail_can_added()
    {
        $response = $this->post('/test/pengguna/unit-kerja', [
            'position_detail' => 'Kepala Bidang IPTEK',
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function position_detail_with_character_less_than_3_cant_added()
    {
        $response = $this->post('/test/pengguna/unit-kerja', [
            'position_detail' => 'aa',
        ]);

        $response->assertRedirect();
    }

    /** @test */
    public function position_detail_with_character_more_than_50_cant_added()
    {
        $response = $this->post('/test/pengguna/unit-kerja', [
            'position_detail' => $this->faker->text(200),
        ]);

        $response->assertRedirect();
    }
}
