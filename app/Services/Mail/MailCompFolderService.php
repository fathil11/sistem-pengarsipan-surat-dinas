<?php

namespace App\Services\Mail;

use App\MailFolder;
use App\Http\Requests\MailCompFolderRequest;

class MailCompFolderService
{
    /** Store Mail Folder */
    public static function store(MailCompFolderRequest $request)
    {
        // Validate Form
        $request->validated();

        // Create Mail Folder
        MailFolder::create([
            'folder' => $request->folder,
        ]);

        return response(200);
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

        return response(200);
    }

    /** Delete Mail Folder */
    public static function delete($id)
    {
        // Check Mail Folder is Exists
        $mail_folder = MailFolder::findOrFail($id);
        $mail_folder->delete();
        return response(200);
    }
}
