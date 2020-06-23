<?php

namespace App\Services\User;

use App\UserPosition;
use App\Http\Requests\UserPositionRequest;

class UserPositionService
{
    /** Store User Position */
    public static function store(UserPositionRequest $request)
    {
        // Validate Form
        $request->validated();

        // Check Role format is Correct
        if (!UserPosition::checkRoleIsExists($request->role)) {
            return redirect()->back()->withErrors('Format akses tidak sesuai !');
        }

        // Create UserPosition
        UserPosition::create([
            'position' => $request->position,
            'role' => $request->role
        ]);

        return response(200);
    }

    /** Update User Position */
    public static function update(UserPositionRequest $request, $id)
    {
        // Validate Form
        $request->validated();

        // Check UserPosition is Exists
        $user_position = UserPosition::findOrFail($id);

        // Check Role format is Correct
        if (!UserPosition::checkRoleIsExists($request->role)) {
            return redirect()->back()->withErrors('Format akses tidak sesuai !');
        }

        // Update UserPosition
        $user_position->update([
            'position' => $request->position,
            'role' => $request->role
        ]);

        return response(200);
    }

    /** Delete User Position */
    public static function delete($id)
    {
        // Check UserPosition is Exists
        $user_position = UserPosition::findOrFail($id);
        $user_position->delete();
        return response(200);
    }
}
