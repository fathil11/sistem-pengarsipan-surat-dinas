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
        $this->withoutExceptionHandling();

        $response = $this->post('/test/user/jabatan', [
            'position' => 'Testing',
            'role' => 'admin'
        ]);

        $response->assertOk();
    }

    /** @test */
    public function false_role_cant_added()
    {
        $response = $this->post('/test/user/jabatan', [
            'position' => 'Testing',
            'role' => 'test'
        ]);

        $response->assertRedirect();
    }

    /** @test */
    public function position_with_less_than_3_letters_cant_added()
    {
        $response = $this->post('/test/user/jabatan', [
            'position' => 'aa',
            'role' => 'test'
        ]);

        $response->assertRedirect();
    }

    /** @test */
    public function role_with_less_than_3_letters_cant_added()
    {
        $response = $this->post('/test/user/jabatan', [
            'position' => 'Testing',
            'role' => 'aa'
        ]);

        $response->assertRedirect();
    }
}
