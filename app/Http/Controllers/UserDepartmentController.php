<?php

namespace App\Http\Controllers;

use App\UserDepartment;
use Illuminate\Http\Request;
use App\Http\Requests\UserDepartmentRequest;

class UserDepartmentController extends Controller
{
    /**
       User Department Controller
        Available Functions :
            1.  index => Show List of User Department
            2.  create => Show Form Create User Department
            3.  store => Store User Department
            4.  edit => Show Form Edit User Department
            5.  update => Update User Department
            6.  destroy => Delete User Department
    */

    public function index()
    {
        $user_departments = UserDepartment::all();
        return view('app.users.settings.department.department-list', compact('user_departments'));
    }

    public function create()
    {
        return view('app.users.settings.department.department-add');
    }

    public function store(UserDepartmentRequest $request)
    {
        UserDepartment::create($request);

        return redirect('/pengguna/pengaturan/bidang')->with('success', 'Berhasil menambahkan bidang');
    }

    public function edit($id)
    {
        $user_department = UserDepartment::findOrFail($id);
        return view('app.users.settings.department.department-edit', compact('user_department'));
    }

    public function update(UserDepartmentRequest $request, $id)
    {
        $user_department = UserDepartment::findOrFail($id);
        $user_department->update($request);

        return redirect('/pengguna/pengaturan/bidang')->with('success', 'Berhasil mengubah bidang');
    }

    public function destroy($id)
    {
        $user_department = UserDepartment::findOrFail($id);
        $user_department->delete();

        return redirect('/pengguna/pengaturan/bidang')->with('success', 'Berhasil menghapus bidang');
    }
}
