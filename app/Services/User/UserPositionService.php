<?php

namespace App\Services\User;

use App\UserPosition;
use App\Http\Requests\UserPositionRequest;

class UserPositionService
{
    /**Show User List */
    public static function shows()
    {
        $user_positions = UserPosition::all();
        return view('app.users.settings.position.position-list', compact('user_positions'));
    }

    /** Create User Position */
    public static function create()
    {
        return view('app.users.settings.position.position-add');
    }

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

        return redirect('/pengguna/pengaturan/jabatan')->with('success', 'Berhasil menambahkan jabatan');
    }

    /** Edit User Position */
    public static function edit($id)
    {
        $user_position = UserPosition::findOrFail($id);
        return view('app.users.settings.position.position-edit', compact('user_position'));
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

        return redirect('/pengguna/pengaturan/jabatan')->with('success', 'Berhasil mengubah jabatan');
    }

    /** Delete User Position */
    public static function delete($id)
    {
        // Check UserPosition is Exists
        $user_position = UserPosition::findOrFail($id);
        $user_position->delete();
        return redirect('/pengguna/pengaturan/jabatan')->with('success', 'Berhasil menghapus jabatan');
    }
}
