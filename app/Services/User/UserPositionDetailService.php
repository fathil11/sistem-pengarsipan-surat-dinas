<?php

namespace App\Services\User;

use App\UserPositionDetail;
use App\Http\Requests\UserPositionDetailRequest;

class UserPositionDetailService
{
    /** Store User Position Detail */
    public static function store(UserPositionDetailRequest $request)
    {
        // Validate Form
        $request->validated();

        // Create UserDepartment
        UserPositionDetail::create([
            'position_detail' => $request->position_detail,
        ]);

        return response(200);
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

        return response(200);
    }

    /** Delete User Position Detail */
    public static function delete($id)
    {
        // Check UserPositionDetail is Exists
        $user_position_detail = UserPositionDetail::findOrFail($id);
        $user_position_detail->delete();
        return response(200);
    }
}
