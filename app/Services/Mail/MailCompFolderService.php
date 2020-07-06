<?php

namespace App\Services\Mail;

use App\MailFolder;
use App\Http\Requests\MailCompFolderRequest;

class MailCompFolderService
{
    /** Show Mail Folder List */
    public static function shows()
    {
        $mail_folders = MailFolder::all();
        return view('app.mails.settings.folder.folder-list', compact('mail_folders'));
    }

    /** Create Mail Folder */
    public static function create()
    {
        return view('app.mails.settings.folder.folder-add');
    }

    /** Store Mail Folder */
    public static function store(MailCompFolderRequest $request)
    {
        // Validate Form
        $request->validated();

        // Create Mail Folder
        MailFolder::create([
            'folder' => $request->folder,
        ]);

        return true;
    }

    /** Edit Mail Folder */
    public static function edit($id)
    {
        $mail_folder = MailFolder::findOrFail($id);
        return view('app.mails.settings.folder.folder-edit', compact('mail_folder'));
    }

    /** Update Mail Folder */
    public static function update(MailCompFolderRequest $request, $id)
    {
        // Validate Form
        $request->validated();

        // Check Mail Folder is Exists
        $mail_folder = MailFolder::findOrFail($id);

        // Update Mail Folder
        $mail_folder->update([
            'folder' => $request->folder,
        ]);

        return true;
    }

    /** Delete Mail Folder */
    public static function delete($id)
    {
        // Check Mail Folder is Exists
        $mail_folder = MailFolder::findOrFail($id);
        $mail_folder->delete();
        return true;
    }
}
