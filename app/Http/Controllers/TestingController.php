<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\User;

use App\Mail;
use App\MailVersion;
use App\MailFile;
use App\MailTransaction;

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

            // 'file' => 'required|file|mimes:pdf,doc,docx,jpeg,jpg,png|size:5120',
        ]);

        if (MailFolder::find($request->mail_folder_id)->exists() &&
            MailPriority::find($request->mail_priority_id)->exists() &&
            MailType::find($request->mail_type_id)->exists() &&
            MailReference::find($request->mail_reference_id)->exists()) {
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
                'version' => '1',
            ]);

            // - Create Mail File
            // - mail_version_id -> id Created mail version
            // - original_name -> "getOriginalFileName()"
            // - type -> File extension

            // === Create & Store File (Mail File) ===
            // $file = $request->file('file');

            // MailFile::create([
            //     'mail_version_id' => $mail_version->id,
            //     'original_name' => $file->getClientOriginalName(),
            //     'directory_name' => $file->store('documents'),
            //     'type' => $file->getClientOriginalExtension(),
            // ]);

            // - Create Mail Transaction
            // - mail_version_id -> id Created mail version
            // - user_id -> Auth
            // - target_user_id -> All user (Sekrestaris)
            // - type -> create

            // === Create MailTransaction ===
            $secretaries = UserPosition::getUsersInRole("sekretaris");
            foreach($secretaries as $secretary){
                dd($secretary);
                $secretary_data = User::where('user_position_id', $secretary->id)->get();
                MailTransaction::create([
                    'mail_version_id' => $mail_version->id,
                    'user_id' => Auth::user()->id,
                    'target_user_id' => $secretary_data->id,
                    'type' => 'create',
                ]);
            }
            return response(200);

        } else {
            return response(302);
        }
    }

    public function updateMailIn(Request $request, Mail $mail){

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
            Mail::where('id', $mail->id)
            ->update([
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
                'mail_updated_at' => Carbon::now(),
            ]);

            // === UPDATE MailVersion ===
            $mail_version_last = Mail::find($mail->id)->mailVersions()->latest();
            $mail_version = MailVersion::create([
                'mail_id' => $mail->id,
                'version' => $mail_version_last->version+1,
            ]);

            if (request()->has('file')){
                // === Create & Store File (Mail File) ===
                $request->validate([
                    'file' => 'required|file|mimes:pdf,doc,docx,jpeg,jpg,png|size:5120',
                ]);

                $file = $request->file('file');

                MailFile::create([
                    'mail_version_id' => $mail_version->id,
                    'original_name' => $file->getClientOriginalName(),
                    'directory_name' => $file->store('documents'),
                    'type' => $file->getClientOriginalExtension(),
                ]);
            }

            // - Create Mail Transaction
            // - mail_version_id -> id Created mail version
            // - user_id -> Auth
            // - target_user_id -> All user (Sekrestaris)
            // - type -> create

            // === Create MailTransaction ===
            $mail_transactions = MailVersion::find($mail_version_last)->mailTransactions();
            foreach($mail_transactions as $mail_transaction){
                MailTransaction::where('id', $mail_transaction->id)
                ->update([
                    'mail_version_id' => $mail_version->id,
                ]);
            }
            return response(200);

        } else {
            return response(302);
        }
    }

    public function storeMailType()
    {
        MailType::create($this->validateMailComponent());
        return response(200);
    }

    public function storeMailPriority()
    {
        MailPriority::create($this->validateMailComponent());
        return response(200);
    }

    public function storeMailReference()
    {
        MailReference::create($this->validateMailComponent());
        return response(200);
    }

    private function validateMailComponent()
    {
        return request()->validate([
            'type' => 'required|min:3|max:50',
            'code' => 'required|min:2|max:50',
            'color' => 'required|min:3|max:50',
        ]);
    }
}
