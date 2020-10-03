<?php

namespace App\Http\Controllers;

use App\MailFolder;
use App\Http\Requests\MailCompFolderRequest;
use Illuminate\Http\Request;

class MailFolderController extends Controller
{
    /**
        Mail Folder Controller
        Available Functions :
            1.  index => Show List of Mail Folder
            2.  create => Show Form Create Mail Folder
            3.  store => Store Mail Folder
            4.  edit => Show Form Edit Mail Folder
            5.  update => Update Mail Folder
            6.  destroy => Delete Mail Folder
    */

    public function index()
    {
        $mail_folders = MailFolder::all();
        return view('app.mails.settings.folder.folder-list', compact('mail_folders'));
    }

    public function create()
    {
        return view('app.mails.settings.folder.folder-add');
    }

    public function store(MailCompFolderRequest $request)
    {
        MailFolder::create($request);
        return redirect('/surat/pengaturan/folder-surat')->with('Berhasil menambahkan folder surat');
    }

    public function edit($id)
    {
        $mail_folder = MailFolder::findOrFail($id);
        return view('app.mails.settings.folder.folder-edit', compact('mail_folder'));
    }

    public function update(MailCompFolderRequest $request, $id)
    {
        $mail_folder = MailFolder::findOrFail($id);
        $mail_folder->update($request);

        return redirect('/surat/pengaturan/folder-surat')->with('Berhasil mengupdate folder surat');
    }

    public function destroy($id)
    {
        $mail_folder = MailFolder::findOrFail($id);
        $mail_folder->delete();

        return redirect('/surat/pengaturan/folder-surat')->with('Berhasil menghapus folder surat');
    }
}
