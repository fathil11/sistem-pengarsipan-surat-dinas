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


    /** @test */
    public function a_position_detail_can_added()
    {
        $response = $this->createUserPositionDetail();
        $response->assertOk();
    }

    /** @test */
    public function a_position_detail_can_updated()
    {
        $this->createUserPositionDetail();

        $response = $this->patch('/test/pengguna/unit-kerja/1', [
            'position_detail' => 'Updated Kepala Bidang IPTEK',
        ]);
        $response->assertOk();
    }

    /** @test */
    public function a_position_detail_can_deleted()
    {
        $this->createUserPositionDetail();
        $response = $this->delete('/test/pengguna/unit-kerja/1');
        $response->assertOk();
    }

    /** @test */
    public function position_detail_with_character_less_than_3_cant_added()
    {
        $response = $this->post('/test/pengguna/unit-kerja', [
            'position_detail' => 'aa',
        ]);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function position_detail_with_character_more_than_50_cant_added()
    {
        $response = $this->post('/test/pengguna/unit-kerja', [
            'position_detail' => $this->faker->text(200),
        ]);

        $response->assertSessionHasErrors();
    }

    private function createUserPositionDetail()
    {
        return $this->post('/test/pengguna/unit-kerja', [
            'position_detail' => 'Kepala Bidang IPTEK',
        ]);
    }
}
