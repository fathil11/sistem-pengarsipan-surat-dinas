<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\MailReference;

use App\Http\Requests\MailComponentsRequest;

class MailReferenceController extends Controller
{
    /**
        Mail Reference Controller
        Available Functions :
            1.  index => Show List of Mail Reference
            2.  create => Show Form Create Mail Reference
            3.  store => Store Mail Reference
            4.  edit => Show Form Edit Mail Reference
            5.  update => Update Mail Reference
            6.  destroy => Delete Mail Reference
    */

    // Show List of Mail Reference
    public function index()
    {
        $mail_references = MailReference::all();
        return view('app.mails.settings.reference.reference-list', compact('mail_references'));
    }

    // Show Form Create Mail Reference
    public function create()
    {
        return view('app.mails.settings.reference.reference-add');
    }

    // Store Mail Reference
    public function store(MailComponentsRequest $request)
    {
        MailReference::create($request);
        return redirect('surat/pengaturan/sifat-surat')->with('success', 'Berhasil menambahkan sifat surat');
    }

    // Show Form Edit Mail Reference
    public function edit($id)
    {
        $mail_reference = MailReference::findOrFail($id);
        return view('app.mails.settings.reference.reference-edit', compact('mail_reference'));
    }

    // Update Mail Reference
    public function update(MailComponentsRequest $request, $id)
    {
        $mail_reference = MailReference::findOrFail($id);
        $mail_reference->update($request);

        return redirect('surat/pengaturan/sifat-surat')->with('success', 'Berhasil mengupdate sifat surat');

    }

    // Delete Mail Reference
    public function destroy($id)
    {
        $mail_reference = MailReference::findOrFail($id);
        $mail_reference->delete();

        return redirect('surat/pengaturan/sifat-surat')->with('success', 'Berhasil menghapus sifat surat');
    }
}
