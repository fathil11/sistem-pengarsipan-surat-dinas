<?php

namespace App\Services\User;

use App\UserPositionDetail;
use App\Http\Requests\UserPositionDetailRequest;

class UserPositionDetailService
{
    /** Show User Position Detail List */
    public static function shows()
    {
        $user_position_details = UserPositionDetail::all();
        return view('app.users.settings.position-detail.position-detail-list', compact('user_position_details'));
    }

    /** Create User Position Detail */
    public static function create()
    {
        return view('app.users.settings.position-detail.position-detail-add');
    }

    /** Store User Position Detail */
    public static function store(UserPositionDetailRequest $request)
    {
        // Validate Form
        $request->validated();

        // Create UserDepartment
        UserPositionDetail::create([
            'position_detail' => $request->position_detail,
        ]);

        return redirect('/pengguna/pengaturan/unit-kerja');
    }

    /** Edit User Position Detail */
    public static function edit($id)
    {
        $user_position_detail = UserPositionDetail::findOrFail($id);
        return view('app.users.settings.position-detail.position-detail-edit', compact('user_position_detail'));
    }

    /** Update User Position Detail */
    public static function update(UserPositionDetailRequest $request, $id)
    {
        // Validate Form
        $request->validated();

        // Check UserPositionDetail is Exists
        $user_position_detail = UserPositionDetail::findOrFail($id);

        // Update UserPositionDetail
        $user_position_detail->update([
            'position_detail' => $request->position_detail,
        ]);

        return redirect('/pengguna/pengaturan/unit-kerja');
    }

    /** Delete User Position Detail */
    public static function delete($id)
    {
        // Check UserPositionDetail is Exists
        $user_position_detail = UserPositionDetail::findOrFail($id);
        $user_position_detail->delete();
        return redirect('/pengguna/pengaturan/unit-kerja');
    }
}
