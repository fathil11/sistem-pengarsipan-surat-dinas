<?php

namespace App\Services\User;

use App\User;
use App\UserPosition;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**Show User List */
    public static function shows()
    {
        $users = User::all();
        return view('app.users.user-list', compact('users'));
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
                return redirect()->back()->withErrors('Bidang tidak boleh kosong !');
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
        return response(200);
    }

    /** Update User */
    public static function update(UserRequest $request, $id)
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

        return response(200);
    }

    /** Delete User */
    public static function delete($id)
    {
        // Check User is Exists
        $user = User::findOrFail($id);

        $user->delete();
        return response(200);
    }
}
