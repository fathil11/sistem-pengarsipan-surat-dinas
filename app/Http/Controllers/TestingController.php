<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

use App\User;
use App\UserPosition;

use App\Mail;
use App\MailVersion;
use App\MailFile;
use App\MailTransaction;
use App\MailLog;
use App\MailMemo;

use App\MailFolder;
use App\MailPriority;
use App\MailReference;
use App\MailType;

use Carbon\Carbon;

class TestingController extends Controller
{
    public function storeMailIn(Request $request)
    {
        // TODO:
        // - Check Role (TU)
        // Fail -> return abort:401, "Anda tidak memiliki akses"

        // - Form field validation
        //     - Mail
        //     - Mail File
        //         - Required
        //         - Mimes : pdf, doc, jpg, jpeg, png
        //         - Max Size : 5MB

        // === Validation ===
        $request->validate([
            'directory_code' => 'required|min:3|max:50',
            'code' => 'required|min:2|unique:mails|max:50',
            'title' => 'required|min:3|max:255',
            'origin' => 'required|min:3|max:50',
            'mail_folder_id' => 'required|numeric',
            'mail_type_id' => 'required|numeric',
            'mail_reference_id' => 'required|numeric',
            'mail_priority_id' => 'required|numeric',
            'mail_created_at' => 'required|date',

            'file' => 'required|file|mimes:pdf,doc,docx,jpeg,jpg,png|max:5120',
        ]);

        if (MailFolder::where('id', $request->mail_folder_id)->exists() &&
            MailPriority::where('id', $request->mail_priority_id)->exists() &&
            MailType::where('id', $request->mail_type_id)->exists() &&
            MailReference::where('id', $request->mail_reference_id)->exists()) {
            // === Query ===
            // - Create Mail
            // - fill attr
            // - fill property attr w id table

            // === Create Mail ===
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

            // - Create Mail Version
            // - mail_id -> id Created mail
            // - version -> inc

            // === Create MailVersion ===
            $mail_version = MailVersion::create([
                'mail_id' => $mail->id,
                // 'version' => '1',
            ]);

            // - Create Mail File
            // - mail_version_id -> id Created mail version
            // - original_name -> "getOriginalFileName()"
            // - type -> File extension

            // === Create & Store File (Mail File) ===
            $file = $request->file('file');

            MailFile::create([
                'mail_version_id' => $mail_version->id,
                'original_name' => $file->getClientOriginalName(),
                'directory_name' => $file->store('documents'),
                'type' => $file->getClientOriginalExtension(),
            ]);

            // - Create Mail Transaction
            // - mail_version_id -> id Created mail version
            // - user_id -> Auth
            // - target_user_id -> All user (Sekrestaris)
            // - type -> create

            // === Create MailTransaction ===
            $user = User::findOrFail(Auth::user()->id);
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

        } else {
            return redirect('/');
        }
    }

    public function updateMailIn(Request $request, $id)
    {
        $mail = Mail::findOrFail($id);
        if ($mail->kind != 'in'){
            return response(403);
        }

        $mail_version_last = $mail->mailVersions->last();
        $user = User::findOrFail(Auth::user()->id);

        $check_if_mail_has_memo = MailTransaction::where('mail_version_id', $mail_version_last->id)->where('type', 'memo')->first();

        if ($check_if_mail_has_memo){
            return redirect('/');
        }

        // === Validation ===
        $request->validate([
            'directory_code' => 'required|min:3|max:50',
            'code' => 'required|min:2|unique:mails|max:50',
            'title' => 'required|min:3|max:255',
            'origin' => 'required|min:3|max:50',
            'mail_folder_id' => 'required|numeric',
            'mail_type_id' => 'required|numeric',
            'mail_reference_id' => 'required|numeric',
            'mail_priority_id' => 'required|numeric',
            'mail_created_at' => 'required|date',
        ]);

        if (MailFolder::find($request->mail_folder_id)->exists() &&
            MailPriority::find($request->mail_priority_id)->exists() &&
            MailType::find($request->mail_type_id)->exists() &&
            MailReference::find($request->mail_reference_id)->exists()) {

            // === UPDATE Mail ===
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

            // === UPDATE MailVersion ===
            $mail_version = MailVersion::create([
                'mail_id' => $mail->id,
                // 'version' => $mail_version_last->version+1,
            ]);

            if (request()->has('file')){
                // === Create & Store File (Mail File) ===
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
            $mail_transaction_last = MailTransaction::where('mail_version_id', $mail_version_last->id)->get()->last();

            // Add Corrected Log to Editor
            MailLog::create([
                'mail_transaction_id' => $mail_transaction_last->id,
                'log' => 'corrected'
            ]);

            // - Create Mail Transaction
            // - mail_version_id -> id Created mail version
            // - user_id -> Auth
            // - target_user_id -> All user (Sekrestaris)
            // - type -> create

            // === Create MailTransaction ===
            $target_user = User::select('id')->withPosition('Sekretaris')->first();

            $mail_transaction = MailTransaction::create([
                'mail_version_id' => $mail_version->id,
                'user_id' => $user->id,
                'target_user_id' => $target_user->id,
                'type' => 'corrected',
            ]);
            MailLog::create([
                'mail_transaction_id' => $mail_transaction->id,
                'log' => 'send',
            ]);
            // $users = User::select('id')->withRole('sekretaris')->get();
            // foreach($users as $user){
            //     $mail_transaction = MailTransaction::create([
            //         'mail_version_id' => $mail_version_last->id,
            //         'user_id' => Auth::user()->id,
            //         'target_user_id' => $user->id,
            //         'type' => 'corrected',
            //     ]);
            //     MailLog::create([
            //         'mail_transaction_id' => $mail_transaction->id,
            //         'log' => 'send',
            //     ]);
            // }
            return response(200);

        } else {
            return redirect('/');
        }
    }

    public function deleteMailIn($id){

        // $mail_version_last = Mail::find($id)->mailVersions->last();
        // $tes = MailVersion::find($mail_version_last->id)->mailTransactions->where('type', 'memo');
        // if (!$tes->isEmpty()){
        //     return redirect('/');
        // }

        $mail = Mail::find($id);
        if ($mail->kind != 'in'){
            return response(403);
        }

        // === UPDATE Mail ===
        Mail::find($id)->delete();
        return response(200);
    }

    public function forwardMailIn(Request $request, $id){
        $mail = Mail::findOrFail($id);
        if ($mail->kind != 'in'){
            return response(403);
        }
        $user = Auth::user();

        $mail_version_last = MailVersion::select('id')->where('mail_id', $id)->get()->last();
        $mail_transaction_last = $mail_version_last->mailTransactions->where('target_user_id', $user->id)->last();
        $memo_transaction_is_empty = $mail_version_last->mailTransactions->where('type', 'memo')->isEmpty();
        $mail_log_last = $mail_transaction_last->transactionLog->last();

        if (($mail_log_last->log != 'send' || $mail_log_last->log != 'read') && !$memo_transaction_is_empty){
            return redirect('/');
        }

        $request->validate([
            'memo' => 'required|min:3|max:1000',
        ]);

        $target_user = User::select('id')->withPosition('Kepala Dinas')->first();

        $mail_transaction = MailTransaction::create([
            'mail_version_id' => $mail_version_last->id,
            'user_id' => $user->id,
            'target_user_id' => $target_user->id,
            'type' => 'memo',
        ]);

        MailMemo::create([
            'mail_transaction_id' => $mail_transaction->id,
            'memo' => $request->memo,
        ]);

        MailLog::create([
            'mail_transaction_id' => $mail_transaction->id,
            'log' => 'send',
        ]);
    }



    public function tes()
    {
        $mail_transaction_last = MailTransaction::where('mail_version_id', 1)->get()->last();
        dd($mail_transaction_last);
        $check_if_mail_has_memo = MailTransaction::where('mail_version_id', 1)->where('type', 'memo')->first();
        if ($check_if_mail_has_memo){
            dd('false');
        }
        dd('success');

        $mail_version_last = Mail::findOrFail(2)->mailVersions->last();
        $tes = MailVersion::find($mail_version_last->id)->mailTransactions->where('type', 'memo')->isEmpty();
        $mail_version_last = MailVersion::where('mail_id', 2)->get()->last();
        dd($mail_version_last);
        $mail_transaction = $mail_version_last->mailTransactions->where('target_user_id', 9)->last();
        $memo_transaction_is_empty = $mail_version_last->mailTransactions->where('type', 'memo')->isEmpty();
        $mail_log = $mail_transaction->transactionLog->last();
        if ($mail_log->log != 'delivered'){
            dump('false');
        }

        dump($memo_transaction_is_empty);
    }
}

