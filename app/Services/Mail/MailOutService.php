<?php

namespace App\Services\Mail;

use App\Mail;
use App\User;
use App\MailLog;
use App\MailFile;
use App\MailVersion;
use App\UserPosition;
use App\MailTransaction;
use App\Mail\Notification;
use App\Repository\MailRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MailOutRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail as Mailer;

class MailOutService
{
    // Store Mail Out
    public static function store($request)
    {

        // Create (Mail)
        $mail = Mail::create([
            'kind' => 'out',
            'title' => $request->title,
            'origin' => $request->origin,
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
        /** @var App\User $user */
        $user = Auth::user();
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
            'log' => 'create',
            'user_id' => $user->id
        ]);

        MailLog::create([
            'mail_transaction_id' => $mail_transaction->id,
            'log' => 'send',
            'user_id' => $user->id
        ]);

        Mailer::to($target_user->email)->send(new Notification($mail));

        return true;
    }

    // Update Mail Out
    public static function update(MailOutRequest $request, $id)
    {
        // Validate Form
        $request->validated();

        // Check Mail is exists and kind of mail out
        $mail = Mail::findOrFail($id);
        if ($mail->kind != 'out') {
            return abort(403, 'Anda tidak punya akses.');
        }

        // Check user is authorized for updating EmailOut
        $update_mail_request = (new MailRepository)->withSameStakeHolder('out', false)->count();

        if ($update_mail_request == 0) {
            return abort(403, 'Anda tidak punya akses.');
        }

        // Update Mail
        $mail->update([
            'kind' => 'out',
            'title' => $request->title,
            'origin' => $request->origin,
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
        /** @var App\User $user  */
        $user = Auth::user();
        $target_user = $user->getTopPosition();

        // Create & Process (Mail Transaction)
        $mail_transaction = MailTransaction::create([
            'mail_version_id' => $mail_version->id,
            'user_id' => $user->id,
            'target_user_id' => $target_user->id,
            'type' => 'corrected'
        ]);

        // Add Corrected Log to "current" Transaction
        MailLog::create([
            'mail_transaction_id' => ($mail_transaction->id - 1),
            'log' => 'corrected',
            'user_id' => $user->id
        ]);

        // Add Delivered Log to new Transaction
        MailLog::create([
            'mail_transaction_id' => $mail_transaction->id,
            'log' => 'send',
            'user_id' => $user->id
        ]);

        Mailer::to($target_user->email)->send(new Notification($mail));

        return true;
    }

    public static function delete($id)
    {
        $mail = Mail::findOrFail($id);

        if ($mail->kind != 'out') {
            return abort(404);
        }

        $mail->delete();

        return true;
    }

    // Forward Mail Out
    public static function forward($id)
    {
        // Assign authenticated user
        /** @var App\User $user */
        $user = Auth::user();
        $target_user = $user->getTopPosition();

        $mail = Mail::findOrFail($id);
        //Get Last Mail Version
        $mail_version_last = $mail->mailVersions->last();

        //Check if Last Mail Transaction type isn't 'corrected' or 'create' or 'forward'
        $update_mail_request = (new MailRepository)
        ->withSameStakeHolder('out', false)
        ->where('mail_version_id', $mail_version_last->id)
        ->first();
        //Redirect if Last Mail Transaction type isn't 'corrected' or 'create'
        if ($update_mail_request == null && $update_mail_request->target_user_id != $user->id) {
            return abort(403, 'Anda tidak punya akses !');
        }

        // Create & Process (Mail Transaction)
        $mail_transaction = MailTransaction::create([
            'mail_version_id' => $mail_version_last->id,
            'user_id' => $user->id,
            'target_user_id' => $target_user->id,
            'type' => 'forward'
        ]);

        MailLog::create([
            'mail_transaction_id' => $mail_transaction->id,
            'log' => 'send',
            'user_id' => $user->id
        ]);

        Mailer::to($target_user->email)->send(new Notification($mail));

        return true;
    }
}
