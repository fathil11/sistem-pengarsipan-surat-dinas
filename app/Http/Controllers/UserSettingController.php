<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Services\User\UserService;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserPositionRequest;
use App\Services\User\UserPositionService;
use App\Http\Requests\UserDepartmentRequest;
use App\Services\User\UserDepartmentService;
use App\Http\Requests\UserPositionDetailRequest;
use App\Services\User\UserPositionDetailService;

class UserSettingController extends Controller
{
    // User
    public function showUsers()
    {
        return UserService::shows();
    }

    public function createUser()
    {
        return UserService::create();
    }

    public function storeUser(UserRequest $request)
    {
        return UserService::store($request);
    }

    public function editUser($id)
    {
        return UserService::edit($id);
    }

    public function updateUser(UserUpdateRequest $request, $id)
    {
        return UserService::update($request, $id);
    }

    public function deleteUser($id)
    {
        return UserService::delete($id);
    }


    // User Position
    public function showUsersPosition()
    {
        return UserPositionService::shows();
    }

    public function createUserPosition()
    {
        return UserPositionService::create();
    }

    public function storeUserPosition(UserPositionRequest $request)
    {
        return UserPositionService::store($request);
    }

    public function editUserPosition($id)
    {
        return UserPositionService::edit($id);
    }

    public function updateUserPosition(UserPositionRequest $request, $id)
    {
        return UserPositionService::update($request, $id);
    }

    public function deleteUserPosition($id)
    {
        return UserPositionService::delete($id);
    }
}
