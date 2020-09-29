<?php

namespace Tests\Feature;

use App\User;
use App\UserDepartment;
use Tests\TestCase;
use App\UserPosition;
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
    public function a_admin_user_can_added()
    {
        $this->seed();

        $response = $this->createUser('Admin');

        // $session = $response->dumpSession();
        // foreach ($session['baseResponse'] as $key=>$value) {
        //     dump($key);
        // }

        // dd();

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'id' => User::all()->last()->id,
            'user_position_id' => UserPosition::getPositionId('Admin')
        ]);
    }

    /** @test */
    public function a_kepala_dinas_user_can_added()
    {
        $this->seed();

        $response = $this->createUser('Kepala Dinas');

        $this->assertDatabaseHas('users', [
            'id' => User::all()->last()->id,
            'user_position_id' => UserPosition::getPositionId('Kepala Dinas')
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function a_sekretaris_user_can_added()
    {
        $this->seed();

        $response = $this->createUser('Sekretaris');

        $this->assertDatabaseHas('users', [
            'id' => User::all()->last()->id,
            'user_position_id' => UserPosition::getPositionId('Sekretaris')
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function a_kepala_tu_user_can_added()
    {
        $this->seed();

        $response = $this->createUser('Kepala TU');

        $this->assertDatabaseHas('users', [
            'id' => User::all()->last()->id,
            'user_position_id' => UserPosition::getPositionId('Kepala TU')
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function a_kepala_bidang_user_can_added()
    {
        $this->seed();

        $position = 'Kepala Bidang';
        $department_abbreviation = 'IPTEK';

        $response = $this->createUserWithExtra($position, $department_abbreviation);

        $this->assertDatabaseHas('users', [
            'id' => User::all()->last()->id,
            'user_position_id' => UserPosition::getPositionId($position),
            'user_department_id' => UserDepartment::getDepartmentId($department_abbreviation)
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function a_user_can_updated()
    {
        $this->seed();
        $this->createUser('Sekretaris');
        $id = User::all()->last()->id;
        $response = $this->patch('/test/pengguna/'.$id, [
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
        $this->createUser('Sekretaris');
        $id = User::all()->last()->id;
        $response = $this->delete('/test/pengguna/' . $id);

        $this->assertSoftDeleted('users', [
            'id' => $id
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function a_wrong_user_cant_updated()
    {
        $this->seed();
        $this->createUser('Kepala Dinas');

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
    public function a_not_complete_user_cant_added()
    {
        $this->seed();
        $this->createUser('Kepala Dinas');

        $response = $this->post('/test/pengguna', [
            'nip' => $this->faker->creditCardNumber(),
            'name' => $this->faker->name(),
            'user_position_id' => 20,
            'user_department_id' => null,
            'user_position_detail_id' => null,
            'email' => $this->faker->email(),
            'phone_number' => $this->faker->phoneNumber(),
            'username' => $this->faker->userName(),
            'password' => '123123',
        ]);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function a_not_having_extra_user_cant_have_extra()
    {
        $this->seed();
        $this->createUser('Kepala Dinas');
        $id = User::all()->last()->id;

        $response = $this->patch('/test/pengguna/'.$id, [
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

    /** @test */
    public function a_has_extra_not_fill_extra_user_cant_added()
    {
        $this->seed();

        $position = 'Kepala Bidang';
        $department_abbreviation = null;

        $response = $this->createUserWithExtra($position, $department_abbreviation);

        $response->assertSessionHasErrors();
    }

    private function createUser($position)
    {
        return $this->post('/test/pengguna', [
            'nip' => $this->faker->creditCardNumber(),
            'name' => $this->faker->name(),
            'user_position_id' => UserPosition::getPositionId($position),
            'user_department_id' => null,
            'user_position_detail_id' => null,
            'email' => $this->faker->email(),
            'phone_number' => $this->faker->phoneNumber(),
            'username' => $this->faker->userName(),
            'password' => '123123',
        ]);
    }

    private function createUserWithExtra($position, $department)
    {
        if ($department == null) {
            return $this->post('/test/pengguna', [
                'nip' => $this->faker->creditCardNumber(),
                'name' => $this->faker->name(),
                'user_position_id' => UserPosition::getPositionId($position),
                'user_department_id' => null,
                'user_position_detail_id' => null,
                'email' => $this->faker->email(),
                'phone_number' => $this->faker->phoneNumber(),
                'username' => $this->faker->userName(),
                'password' => '123123',
            ]);
        }

        return $this->post('/test/pengguna', [
            'nip' => $this->faker->creditCardNumber(),
            'name' => $this->faker->name(),
            'user_position_id' => UserPosition::getPositionId($position),
            'user_department_id' => UserDepartment::getDepartmentId($department),
            'user_position_detail_id' => null,
            'email' => $this->faker->email(),
            'phone_number' => $this->faker->phoneNumber(),
            'username' => $this->faker->userName(),
            'password' => '123123',
        ]);
    }
}
