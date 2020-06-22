<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\UserPosition;
use App\UserDepartment;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test */
    public function a_user_can_added()
    {
        $this->seed();

        $response = $this->post('/test/pengguna', [
            'nip' => $this->faker->creditCardNumber(),
            'name' => $this->faker->name(),
            'user_position_id' => 1,
            'user_department_id' => null,
            'user_position_detail_id' => null,
            'email' => $this->faker->email(),
            'phone_number' => $this->faker->phoneNumber(),
            'username' => $this->faker->userName(),
            'password' => '123123',
        ]);

        $response->assertStatus(200);
    }
}
