<?php

namespace App\Services\User;

use App\UserDepartment;
use App\Http\Requests\UserDepartmentRequest;

class UserDepartmentService
{
    /** Store User Department */
    public static function store(UserDepartmentRequest $request)
    {
        // Validate Form
        $request->validated();

        // Create UserDepartment
        UserDepartment::create([
            'department' => $request->department,
            'department_abbreviation' => $request->department_abbreviation
        ]);

        return response(200);
    }

    /** Update User Department */
    public static function update(UserDepartmentRequest $request, $id)
    {
        // Validate Form
        $request->validated();

        // Check UserDepartment is Exists
        $user_department = UserDepartment::findOrFail($id);

        // Update UserDepartment
        $user_department->update([
            'department' => $request->department,
            'department_abbreviation' => $request->department_abbreviation
        ]);

        return response(200);
    }

    /** Delete User Department */
    public static function delete($id)
    {
        // Check UserDepartment is Exists
        $user_department = UserDepartment::findOrFail($id);
        $user_department->delete();
        return response(200);
    }
}
