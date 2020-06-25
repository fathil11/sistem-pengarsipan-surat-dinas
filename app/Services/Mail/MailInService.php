<?php

namespace App\Services\Mail;

use Illuminate\Support\Facades\Auth;

use App\User;

use App\Mail;
use App\MailVersion;
use App\MailFile;
use App\MailTransaction;
use App\MailLog;
use App\MailMemo;

use App\Http\Requests\MailInRequest;
use App\Http\Requests\MailMemoRequest;

class MailInService
{
    // Store Mail In
    public static function store(MailInRequest $request)
    {
        // Validate Form
        $request->validated();

        //Create Mail
        $mail = Mail::create([
            'kind' => 'in',
            'directory_code' => $request->directory_code,
            'code' => $request->code,
            'title' => $request->title,
            'origin' => $request->origin,
            'mail_folder_id' => $request->mail_folder_id,
            'mail_type_id' => $request->mail_type_id,
            'mail_reference_id' => $request->mail_reference_id,
            'mail_priority_id' => $request->mail_priority_id,
            'mail_created_at' => $request->mail_created_at,
        ]);

        //Initialize Mail Version
        $mail_version = MailVersion::create([
            'mail_id' => $mail->id,
        ]);

        //Storing Mail File
        $file = $request->file('file');
        $mailFile = MailFile::create([
            'mail_version_id' => $mail_version->id,
            'original_name' => $file->getClientOriginalName(),
            'directory_name' => $file->store('documents'),
            'type' => $file->getClientOriginalExtension(),
        ]);

        //Initialize Mail Transaction to Secretary
        $user = User::select('id')->findOrFail(Auth::user()->id);
        $target_user = User::select('id')->withPosition('Sekretaris')->first();

        $mail_transaction = MailTransaction::create([
            'mail_version_id' => $mail_version->id,
            'user_id' => $user->id,
            'target_user_id' => $target_user->id,
            'type' => 'create',
        ]);

        //Create Log
        MailLog::create([
            'mail_transaction_id' => $mail_transaction->id,
            'log' => 'send',
        ]);

        return response(200);
    }

    //Update Mail In
    public static function update(MailInRequest $request, $id)
    {
        // Validate Form
        $request->validated();

        //Check if Mail Exists and Mail kind is 'in'
        $mail = Mail::findOrFail($id);
        if ($mail->kind != 'in'){
            return abort(403);
        }

        //Get Last Mail Version
        $mail_version_last = $mail->mailVersions->last();

        //Check if Last Mail Transaction type isn't 'memo' or 'archive'
        $last_mail_transaction_is_memo = $mail_version_last->mailTransactions->where('type', 'memo')->isNotEmpty();
        $last_mail_transaction_is_disposition = $mail_version_last->mailTransactions->where('type', 'archive')->isNotEmpty();

        //Redirect if Last Mail Transaction type is 'memo' or 'archive'
        if ($last_mail_transaction_is_memo || $last_mail_transaction_is_disposition){
            return redirect('/');
        }

        // Update Mail
        $mail->update([
            'directory_code' => $request->directory_code,
            'code' => $request->code,
            'title' => $request->title,
            'origin' => $request->origin,
            'mail_folder_id' => $request->mail_folder_id,
            'mail_type_id' => $request->mail_type_id,
            'mail_reference_id' => $request->mail_reference_id,
            'mail_priority_id' => $request->mail_priority_id,
            'mail_created_at' => $request->mail_created_at,
        ]);

        // Create New Version of Mail
        $mail_version = MailVersion::create([
            'mail_id' => $mail->id,
        ]);

        // Check File, if exist Create MailFile
        if (request()->has('file')){
            // Create & Store File (Mail File)
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

        $mail_transaction_last = MailTransaction::select('id')->where('mail_version_id', $mail_version_last->id)->get()->last();

        // Add Corrected Log to Editor
        MailLog::create([
            'mail_transaction_id' => $mail_transaction_last->id,
            'log' => 'corrected'
        ]);

        $user = User::select('id')->findOrFail(Auth::user()->id);

        // === Create MailTransaction ===
        $target_user = User::select('id')->withPosition('Sekretaris')->first();

        $mail_transaction = MailTransaction::create([
            'mail_version_id' => $mail_version->id,
            'user_id' => $user->id,
            'target_user_id' => $target_user->id,
            'type' => 'create',
        ]);

        MailLog::create([
            'mail_transaction_id' => $mail_transaction->id,
            'log' => 'send',
        ]);

        return response(200);
    }

    //Delete Mail In
    public static function delete($id)
    {
        $mail = Mail::findOrFail($id);
        if ($mail->kind != 'in'){
            return response(403);
        }

        $mail->delete();

        return response(200);
    }

    //Forward Mail In
    public static function forward(MailMemoRequest $request, $id){
        // Validate Form
        $request->validated();

        //Check if Mail Exists and Mail kind is 'in'
        $mail = Mail::findOrFail($id);
        if ($mail->kind != 'in'){
            return abort(403);
        }

        //Get Last Mail Version
        $mail_version_last = $mail->mailVersions->last();

        //Check if Last Mail Transaction type is 'memo' or 'archive'
        $last_mail_transaction_is_memo = $mail_version_last->mailTransactions->where('type', 'memo')->isNotEmpty();
        $last_mail_transaction_is_disposition = $mail_version_last->mailTransactions->where('type', 'archive')->isNotEmpty();

        //Redirect if Last Mail Transaction type is 'memo' or 'archive'
        if ($last_mail_transaction_is_memo || $last_mail_transaction_is_disposition){
            return redirect('/');
        }


        $user = User::select('id')->findOrFail(Auth::user()->id);
        $target_user = User::select('id')->withPosition('Kepala Dinas')->first();

        //Create Mail Transaction Memo
        $mail_transaction = MailTransaction::create([
            'mail_version_id' => $mail_version_last->id,
            'user_id' => $user->id,
            'target_user_id' => $target_user->id,
            'type' => 'memo',
        ]);

        //Store Memo
        MailMemo::create([
            'mail_transaction_id' => $mail_transaction->id,
            'memo' => $request->memo,
        ]);

        //Create Mail Log
        MailLog::create([
            'mail_transaction_id' => $mail_transaction->id,
            'log' => 'send',
        ]);
    }
}
