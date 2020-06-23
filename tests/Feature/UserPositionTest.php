<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\UserPosition;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserPositionTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function a_position_can_added()
    {
        $response = $this->createUserPosition();
        $response->assertOk();
    }

    /** @test */
    public function a_position_can_updated()
    {
        $this->createUserPosition();

        $response = $this->patch('/test/pengguna/jabatan/1', [
            'position' => 'Testing Updated',
            'role' => 'admin'
        ]);
        $response->assertOk();
    }

    /** @test */
    public function a_position_can_deleted()
    {
        $this->createUserPosition();
        $response = $this->delete('/test/pengguna/jabatan/1');
        $response->assertOk();
    }

    /** @test */
    public function a_wrong_id_position_cant_updated()
    {
        $this->createUserPosition();

        $response = $this->patch('/test/pengguna/jabatan/xxx', [
            'position' => 'Testing Updated',
            'role' => 'admin'
        ]);

        $response->assertStatus(404);
    }


    /** @test */
    public function false_role_cant_added()
    {
        $response = $this->post('/test/pengguna/jabatan', [
            'position' => 'Testing',
            'role' => 'test'
        ]);

        $response->assertRedirect();
    }

    /** @test */
    public function position_with_less_than_3_characters_cant_added()
    {
        $response = $this->post('/test/pengguna/jabatan', [
            'position' => 'aa',
            'role' => 'test'
        ]);

        $response->assertRedirect();
    }

    /** @test */
    public function role_with_less_than_3_characters_cant_added()
    {
        $response = $this->post('/test/pengguna/jabatan', [
            'position' => 'Testing',
            'role' => 'aa'
        ]);

        $response->assertRedirect();
    }

    private function createUserPosition()
    {
        return $this->post('/test/pengguna/jabatan', [
            'position' => 'Testing',
            'role' => 'admin'
        ]);
    }
}
