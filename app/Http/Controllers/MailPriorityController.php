<?php

namespace App\Http\Controllers;

use App\MailPriority;
use Illuminate\Http\Request;
use App\Http\Requests\MailComponentsRequest;

class MailPriorityController extends Controller
{
    /**
        Mail Priority Controller
        Available Functions :
            1.  index => Show List of Mail Priority
            2.  create => Show Form Create Mail Priority
            3.  store => Store Mail Priority
            4.  edit => Show Form Edit Mail Priority
            5.  update => Update Mail Priority
            6.  destroy => Delete Mail Priority
    */

    public function index()
    {
        $mail_priorities = MailPriority::all();

        return view('app.mails.settings.priority.priority-list', compact('mail_priorities'));
    }

    public function create()
    {
        return view('app.mails.settings.priority.priority-add');
    }

    public function store(MailComponentsRequest $request)
    {
        MailPriority::create($request);

        return redirect('/surat/pengaturan/prioritas-surat')->with('success', 'Berhasil menambahkan prioritas surat');
    }

    public function edit($id)
    {
        $mail_priority = MailPriority::findOrFail($id);

        return view('app.mails.settings.priority.priority-edit', compact('mail_priority'));
    }

    public function update(MailComponentsRequest $request, $id)
    {
        $mail_priority = MailPriority::findOrFail($id);
        $mail_priority->update($request);

        return redirect('/surat/pengaturan/prioritas-surat')->with('success', 'Berhasil mengupdate prioritas surat');
    }

    public function destroy($id)
    {
        $mail_priority = MailPriority::findOrFail($id);
        $mail_priority->delete();

        return redirect('/surat/pengaturan/prioritas-surat')->with('success', 'Berhasil menghapus prioritas surat');
    }
}
