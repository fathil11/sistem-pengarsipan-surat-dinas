<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\UserPosition;
use App\Http\Requests\UserPositionRequest;

class UserPositionController extends Controller
{
    /**
        User Position Controller
        Available Functions :
            1.  index => Show List of User Position
            2.  create => Show Form Create User Position
            3.  store => Store User Position
            4.  edit => Show Form Edit User Position
            5.  update => Update User Position
            6.  destroy => Delete User Position
    */

    // Show List of User Position
    public function index()
    {
        $user_positions = UserPosition::all();
        return view('app.users.settings.position.position-list', compact('user_positions'));
    }

    // Show Form Create User Position
    public function create()
    {
        return view('app.users.settings.position.position-add');
    }

    // Store User Position
    public function store(UserPositionRequest $request)
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

    // Show Form Edit User Position
    public function edit($id)
    {
        $user_position = UserPosition::findOrFail($id);
        return view('app.users.settings.position.position-edit', compact('user_position'));
    }

    // Update User Position
    public function update(UserPositionRequest $request, $id)
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

    // Delete User Position
    public function destroy($id)
    {
        // Check UserPosition is Exists
        $user_position = UserPosition::findOrFail($id);
        $user_position->delete();

        return redirect('/pengguna/pengaturan/jabatan')->with('success', 'Berhasil menghapus jabatan');
    }
}
