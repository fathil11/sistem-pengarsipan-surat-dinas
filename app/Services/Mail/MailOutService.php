<?php

namespace App\Services\Mail;

use App\Mail;
use App\User;
use App\MailLog;
use App\MailFile;
use App\MailVersion;
use App\UserPosition;
use App\MailTransaction;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MailOutRequest;

class MailOutService
{
    // Store Mail Out
    public static function store(MailOutRequest $request)
    {

        // Validate Form
        $request->validated();

        // Create (Mail)
        $mail = Mail::create([
            'kind' => 'out',
            'title' => $request->title,
            'origin' => 'Internal',
            'mail_folder_id' => $request->mail_folder_id,
            'mail_type_id' => $request->mail_type_id,
            'mail_reference_id' => $request->mail_reference_id,
            'mail_priority_id' => $request->mail_priority_id,
            'mail_created_at' => $request->mail_created_at,
        ]);

        // Create & Assign (Mail Version)
        $mail_version = MailVersion::create([
            'mail_id' => $mail->id,
        ]);

        // Create & Store File (Mail File)
        $file = $request->file('file');
        MailFile::create([
            'mail_version_id' => $mail_version->id,
            'original_name' => $file->getClientOriginalName(),
            'directory_name' => $file->store('documents'),
            'type' => $file->getClientOriginalExtension(),
        ]);

        // Assign authenticated user
        $user = User::find(Auth::id());
        $target_user = $user->getTopPosition();

        // Create & Process (Mail Transaction)
        $mail_transaction = MailTransaction::create([
            'mail_version_id' => $mail_version->id,
            'user_id' => $user->id,
            'target_user_id' => $target_user->id,
            'type' => 'create'
        ]);

        MailLog::create([
            'mail_transaction_id' => $mail_transaction->id,
            'log' => 'send'
        ]);

        return response(200);
    }

    // Update Mail Out
    public static function update(MailOutRequest $request, $id)
    {
        // Validate Form
        $request->validated();

        // Check Mail is exists and kind of mail out
        $mail = Mail::findOrFail($id);
        if ($mail->kind != 'out') {
            return abort(403);
        }

        // Get latest MailVersion id
        $last_mail_version_id = $mail->mailVersions->last()->id;

        // Check user is authorized for updating EmailOut
        $update_transaction_request = MailTransaction::withSameStakeholder(Auth::id(), 'out')
            ->where([
            ['mail_version_id', $last_mail_version_id],
            ['type', 'correction'],
            ])->first();

        if ($update_transaction_request == null) {
            return abort(403);
        }
        // Update Mail
        $mail->update([
            'kind' => 'out',
            'title' => $request->title,
            'origin' => 'Internal',
            'mail_folder_id' => $request->mail_folder_id,
            'mail_type_id' => $request->mail_type_id,
            'mail_reference_id' => $request->mail_reference_id,
            'mail_priority_id' => $request->mail_priority_id,
            'mail_created_at' => $request->mail_created_at
        ]);

        // Create & Assign (Mail Version)
        $mail_version = MailVersion::create([
            'mail_id' => $mail->id,
        ]);

        // Check File, if exist Create MailFile
        if (request()->has('file')) {
            // Create & Store Mail File
            $request->validate([
                'file' => 'required|file|mimes:pdf,doc,docx,jpeg,jpg,png|max:5120',
            ]);

            $file = $request->file('file');

            MailFile::create([
                'mail_version_id' => $mail_version->id,
                'original_name' => $file->getClientOriginalName(),
                'directory_name' => $file->store('documents'),
                'type' => $file->getClientOriginalExtension(),
            ]);
        }

        // Assign authenticated user and target user
        $user = User::find(Auth::id());
        $target_user = $user->getTopPosition();

        // Add Corrected Log to "current" Transaction
        MailLog::create([
            'mail_transaction_id' => $update_transaction_request->id,
            'log' => 'corrected'
        ]);

        // Create & Process (Mail Transaction)
        $mail_transaction = MailTransaction::create([
            'mail_version_id' => $mail_version->id,
            'user_id' => $user->id,
            'target_user_id' => $target_user->id,
            'type' => 'send'
        ]);


        // Add Delivered Log to new Transaction
        MailLog::create([
            'mail_transaction_id' => $mail_transaction->id,
            'log' => 'send'
        ]);

        return response(200);
    }

    public static function delete($id)
    {
        $mail = Mail::findOrFail($id);
        if ($mail->kind != 'out') {
            return abort(404);
        }
        $mail->delete();

        return response(200);
    }
}
