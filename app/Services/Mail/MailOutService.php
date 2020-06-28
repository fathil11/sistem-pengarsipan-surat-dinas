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
use App\Repository\MailRepository;
use Illuminate\Database\Eloquent\Builder;

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
            'log' => 'send',
            'user_id' => $user->id
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

        // Check user is authorized for updating EmailOut
        $update_mail_request = (new MailRepository)->withSameStakeHolder('out')->count();

        if ($update_mail_request == 0) {
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
            'log' => 'correction',
            'user_id' => $user->id
        ]);

        MailLog::create([
            'mail_transaction_id' => $mail_transaction->id,
            'log' => 'send',
            'user_id' => $user->id
        ]);

        return true;
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

    // Forward Mail Out
    public static function forward($id)
    {
        //Check if Mail Exists and Mail kind is 'out'
        $mail = Mail::findOrFail($id);
        if ($mail->kind != 'out') {
            return abort(403);
        }

        //Get Last Mail Version
        $mail_version_last = $mail->mailVersions->last();

        //Check if Last Mail Transaction type isn't 'corrected' or 'create' or 'forward'
        $last_mail_transaction_isnt_corrected = $mail_version_last->mailTransactions->where('type', 'corrected')->isEmpty();
        $last_mail_transaction_isnt_create = $mail_version_last->mailTransactions->where('type', 'create')->isEmpty();
        $last_mail_transaction_isnt_forward = $mail_version_last->mailTransactions->where('type', 'forward')->isEmpty();

        //Redirect if Last Mail Transaction type isn't 'corrected' or 'create'
        if ($last_mail_transaction_isnt_corrected || $last_mail_transaction_isnt_create || $last_mail_transaction_isnt_forward) {
            return redirect('/');
        }

        // Assign authenticated user
        /** @var App\User $user */
        $user = Auth::user();
        $target_user = $user->getTopPosition();
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

        return response(200);
    }
}
