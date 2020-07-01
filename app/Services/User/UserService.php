<?php

namespace App\Services\User;

use App\User;
use App\UserPosition;
use App\UserDepartment;
use App\UserPositionDetail;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserUpdateRequest;

class UserService
{
    /**Show User List */
    public static function shows()
    {
        $users = User::with(['position', 'department', 'positionDetail'])->get();
        return view('app.users.user-list', compact('users'));
    }

    /** Create User */
    public static function create()
    {
        $positions = UserPosition::get();
        $position_details = UserPositionDetail::get();
        $departments = UserDepartment::get();

        if ($position_details->count() == 0 || $positions->count() == 0 || $departments->count() == 0) {
            return redirect('/')->withErrors('Silahkan tambahkan jabatan, unit kerja, atau bidang untuk menambahkan user.');
        }
        return view('app.users.user-add')->with(compact('positions', 'position_details', 'departments'));
    }

    /** Store User */
    public static function store(UserRequest $request)
    {
        // Validate Form
        $request->validated();

        // Validate UserPosition is exist
        $position = UserPosition::findOrFail($request->user_position_id);

        // Process UserDepartment & UserPositionDetails
        /*
            User with position role is Admin,
            Kepala Dinas, Sekretaris, or Kepala TU
            does't have UserDepartment and UserPositionDetail.
        */
        $user_department_id = null;
        $user_position_detail_id = null;
        if ($position->checkRoleHasExtra()) {
            // Validate UserDepartment is empty
            if ($request->user_department_id == null) {
                return redirect()->back()->withErrors('Bidang tidak boleh kosong.');
            } elseif ($request->user_department_id != null && $request->user_position_detail_id == null) {
                $request->user_position_detail_id = null;
            }

            $user_department_id = $request->user_department_id;
            $user_position_detail_id = $request->user_position_detail_id;
        }

        // Create User
        User::create([
            'nip' => $request->nip,
            'name' => $request->name,
            'user_position_id' => $request->user_position_id,
            'user_department_id' => $user_department_id,
            'user_position_detail_id' => $user_position_detail_id,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/pengguna/lihat')->with('success', 'Berhasil menambahkan pengguna.');
    }

    /** Edit User Position Detail */
    public static function edit($id)
    {
        $user = User::findOrFail($id);
        $positions = UserPosition::get();
        $position_details = UserPositionDetail::get();
        $departments = UserDepartment::get();
        return view('app.users.user-edit')->with(compact('user', 'positions', 'position_details', 'departments'));
    }

    /** Update User */
    public static function update(UserUpdateRequest $request, $id)
    {
        // Validate Form
        $request->validated();

        // Check User is exists
        $user = User::findOrFail($id);

        // Validate UserPosition id is exist
        $position = UserPosition::findOrFail($request->user_position_id);

        // Process UserDepartment & UserPositionDetails
        /*
            User with position role is Admin,
            Kepala Dinas, Sekretaris, or Kepala TU
            does't have UserDepartment and UserPositionDetail.
        */
        $user_department_id = null;
        $user_position_detail_id = null;

        if ($position->checkRoleHasExtra()) {
            // Valudate UserDepartment is empty
            if ($request->user_department_id == null) {
                return redirect()->back()->withErrors('Bidang tidak boleh kosong !');
            } elseif ($request->user_department_id != null && $request->user_position_detail_id == null) {
                $request->user_position_detail_id = null;
            }

            $user_department_id = $request->user_department_id;
            $user_position_detail_id = $request->user_position_detail_id;
        }

        // Update User
        if ($request->password == null) {
            $user->update([
                'nip' => $request->nip,
                'name' => $request->name,
                'user_position_id' => $request->user_position_id,
                'user_department_id' => $user_department_id,
                'user_position_detail_id' => $user_position_detail_id,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);
        } else {
            $user->update([
                'nip' => $request->nip,
                'name' => $request->name,
                'user_position_id' => $request->user_position_id,
                'user_department_id' => $user_department_id,
                'user_position_detail_id' => $user_position_detail_id,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'username' => $request->username,
            ]);
        }

        return redirect('/pengguna/lihat')->with('success', 'Berhasil mengupdate pengguna');
    }

    /** Delete User */
    public static function delete($id)
    {
        // Check User is Exists
        $user = User::findOrFail($id);

        $user->delete();
        return redirect('/pengguna/lihat')->with('success', 'Berhasil menghapus pengguna');
    }
}
