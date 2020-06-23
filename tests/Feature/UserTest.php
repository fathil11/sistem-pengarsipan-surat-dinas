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

        $response = $this->createUser();
        $response->assertStatus(200);
    }

    /** @test */
    public function a_user_can_updated()
    {
        $this->seed();
        $this->createUser();

        $response = $this->patch('/test/pengguna/1', [
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

    /** @test */
    public function a_user_can_deleted()
    {
        $this->seed();
        $this->createUser();

        $response = $this->delete('/test/pengguna/1');
        $response->assertStatus(200);
    }

    /** @test */
    public function a_wrong_user_cant_updated()
    {
        $this->seed();
        $this->createUser();

        $response = $this->patch('/test/pengguna/xxx', [
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

        $response->assertStatus(404);
    }

    /** @test */
    public function a_not_having_extra_user_cant_have_extra()
    {
        $this->seed();
        $this->createUser();

        $response = $this->patch('/test/pengguna/1', [
            'nip' => $this->faker->creditCardNumber(),
            'name' => $this->faker->name(),
            'user_position_id' => 1,
            'user_department_id' => 2,
            'user_position_detail_id' => 2,
            'email' => $this->faker->email(),
            'phone_number' => $this->faker->phoneNumber(),
            'username' => $this->faker->userName(),
            'password' => '123123',
        ]);

        $response->assertOk();

        $this->assertDatabaseHas('users', [
            'user_position_id' => 1,
            'user_department_id' => null,
            'user_position_detail_id' => null,
        ]);
    }

    private function createUser()
    {
        return $this->post('/test/pengguna', [
            'nip' => '12345678910',
            'name' => $this->faker->name(),
            'user_position_id' => 1,
            'user_department_id' => null,
            'user_position_detail_id' => null,
            'email' => $this->faker->email(),
            'phone_number' => $this->faker->phoneNumber(),
            'username' => $this->faker->userName(),
            'password' => '123123',
        ]);
    }
}
