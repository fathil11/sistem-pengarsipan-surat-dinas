<?php

namespace App\Services\User;

use App\UserDepartment;
use App\Http\Requests\UserDepartmentRequest;

class UserDepartmentService
{
    /**Show User List */
    public static function shows()
    {
        $user_departments = UserDepartment::all();
        return view('app.users.settings.department.department-list', compact('user_departments'));
    }

    /** Create User Department */
    public static function create()
    {
        return view('app.users.settings.department.department-add');
    }

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

        return redirect('/pengguna/pengaturan/bidang');
    }

    /** Edit User Department */
    public static function edit($id)
    {
        $user_department = UserDepartment::findOrFail($id);
        return view('app.users.settings.department.department-edit', compact('user_department'));
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

        return redirect('/pengguna/pengaturan/bidang');
    }

    /** Delete User Department */
    public static function delete($id)
    {
        // Check UserDepartment is Exists
        $user_department = UserDepartment::findOrFail($id);
        $user_department->delete();
        return redirect('/pengguna/pengaturan/bidang');
    }
}
