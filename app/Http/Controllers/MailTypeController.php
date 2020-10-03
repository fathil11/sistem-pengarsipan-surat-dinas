<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\MailType;

use App\Http\Requests\MailComponentsRequest;

class MailTypeController extends Controller
{
    /**
        Mail Type Controller
        Available Functions :
            1.  index => Show List of Mail Type
            2.  create => Show Form Create Mail Type
            3.  store => Store Mail Type
            4.  edit => Show Form Edit Mail Type
            5.  update => Update Mail Type
            6.  destroy => Delete Mail Type
    */

    // Show List of Mail Type
    public function index()
    {
        $mail_types = MailType::all();
        return view('app.mails.settings.type.type-list', compact('mail_types'));
    }

    // Show Form Create Mail Type
    public function create()
    {
        return view('app.mails.settings.type.type-add');
    }

    // Store Mail Type
    public function store(MailComponentsRequest $request)
    {
        MailType::create($request);
        return redirect('/surat/pengaturan/jenis-surat')->with('success', 'Berhasil menambahkan jenis surat');
    }

    // Show Form Edit Mail Type
    public function edit($id)
    {
        $mail_type = MailType::findOrFail($id);
        return view('app.mails.settings.type.type-edit', compact('mail_type'));
    }

    // Update Mail Type
    public function update(MailComponentsRequest $request, $id)
    {
        $mail_type = MailType::findOrFail($id);
        $mail_type->update($request);

        return redirect('/surat/pengaturan/jenis-surat')->with('success', 'Berhasil mengupdate jenis surat');
    }

    // Delete Mail Type
    public function destroy($id)
    {
        // Check Mail Type is Exists
        $mail_type = MailType::findOrFail($id);
        $mail_type->delete();

        return redirect('/surat/pengaturan/jenis-surat')->with('success', 'Berhasil menghapus jenis surat');
    }
}
