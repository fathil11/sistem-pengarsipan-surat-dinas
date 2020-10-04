<?php

namespace App\Http\Controllers;

use App\UserPositionDetail;
use App\Http\Requests\UserPositionDetailRequest;
use Illuminate\Http\Request;

class UserPositionDetailController extends Controller
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

    public function index()
    {
        $user_position_details = UserPositionDetail::all();
        return view('app.users.settings.position-detail.position-detail-list', compact('user_position_details'));
    }

    public function create()
    {
        return view('app.users.settings.position-detail.position-detail-add');
    }

    public function store(UserPositionDetailRequest $request)
    {
        UserPositionDetail::create($request);

        return redirect('/pengguna/pengaturan/unit-kerja')->with('success', 'Berhasil menambahkan unit kerja');
    }

    public function edit($id)
    {
        $user_position_detail = UserPositionDetail::findOrFail($id);
        return view('app.users.settings.position-detail.position-detail-edit', compact('user_position_detail'));
    }

    public function update(UserPositionDetailRequest $request, $id)
    {
        $user_position_detail = UserPositionDetail::findOrFail($id);
        $user_position_detail->update($request);

        return redirect('/pengguna/pengaturan/unit-kerja')->with('success', 'Berhasil mengubah unit kerja');
    }

    public function destroy($id)
    {
        $user_position_detail = UserPositionDetail::findOrFail($id);
        $user_position_detail->delete();

        return redirect('/pengguna/pengaturan/unit-kerja')->with('success', 'Berhasil menghapus unit kerja');
    }
}
