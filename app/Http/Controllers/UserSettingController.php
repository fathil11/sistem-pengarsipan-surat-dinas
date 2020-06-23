<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Services\User\UserService;
use App\Http\Requests\UserPositionRequest;
use App\Services\User\UserPositionService;
use App\Http\Requests\UserDepartmentRequest;
use App\Services\User\UserDepartmentService;
use App\Http\Requests\UserPositionDetailRequest;
use App\Services\User\UserPositionDetailService;

class UserSettingController extends Controller
{
    // User
    public function storeUser(UserRequest $request)
    {
        return UserService::store($request);
    }

    public function updateUser(UserRequest $request, $id)
    {
        return UserService::update($request, $id);
    }

    public function deleteUser($id)
    {
        return UserService::delete($id);
    }


    // User Position
    public function storeUserPosition(UserPositionRequest $request)
    {
        return UserPositionService::store($request);
    }

    public function updateUserPosition(UserPositionRequest $request, $id)
    {
        return UserPositionService::update($request, $id);
    }

    public function deleteUserPosition($id)
    {
        return UserPositionService::delete($id);
    }


    // User Department
    public function storeUserDepartment(UserDepartmentRequest $request)
    {
        return UserDepartmentService::store($request);
    }

    public function updateUserDepartment(UserDepartmentRequest $request, $id)
    {
        return UserDepartmentService::update($request, $id);
    }

    public function deleteUserDepartment($id)
    {
        return UserDepartmentService::delete($id);
    }


    // User Department
    public function storeUserPositionDetail(UserPositionDetailRequest $request)
    {
        return UserPositionDetailService::store($request);
    }

    public function updateUserPositionDetail(UserPositionDetailRequest $request, $id)
    {
        return UserPositionDetailService::update($request, $id);
    }

    public function deleteUserPositionDetail($id)
    {
        return UserPositionDetailService::delete($id);
    }
}
