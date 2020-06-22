<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\User;
use App\UserPosition;

use App\Mail;
use App\MailVersion;
use App\MailFile;
use App\MailTransaction;

use App\MailFolder;
use App\MailPriority;
use App\MailReference;
use App\MailType;

class TestingController extends Controller
{
    public function storeMailIn(Request $request)
    {
        // TODO:
            // - Check Role (TU)
            // Fail -> return abort:401, "Anda tidak memiliki akses"

            // === Validation ===
            // - Form field validation
            //     - Mail
            //     - Mail File
            //         - Required
            //         - Mimes : pdf, doc, jpg, jpeg, png
            //         - Max Size : 5MB
            $request->validate([
                'directory_code' => 'required|min:3|max:50',
                'code' => 'required|min:3|unique:mails|max:50',
                'title' => 'required|min:3|max:50',
                'origin' => 'required|min:3|max:50',
                'mail_folder_id' => 'required|numeric',
                'mail_type_id' => 'required|numeric',
                'mail_reference_id' => 'required|numeric',
                'mail_priority_id' => 'required|numeric',
                'mail_created_at' => 'required|date',

                'file' => 'required|file|mimes:pdf,doc,docx,jpeg,jpg,png|size:5120',
            ]);

            if (MailFolder::find($request->priority)->exists() &&
                MailPriority::find($request->priority)->exists() &&
                MailType::find($request->type)->exists() &&
                MailReference::find($request->reference)->exists()) {
                    // === Query ===
                    // - Create Mail
                    // - fill attr
                    // - fill property attr w id table
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

                    $mail_version = MailVersion::create([
                        'mail_id' => $mail->id,
                        'version' => '1',
                    ]);

                    // - Create Mail File
                    // - mail_version_id -> id Created mail version
                    // - original_name -> "getOriginalFileName()"
                    // - type -> File extension

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

                    $secretaries = User::getUsersInRole("sekretaris");
                    foreach($secretaries as $secretary){
                        $secretary_data = User::where('position_id', $secretary->id)->get();
                        MailTransaction::create([
                            'mail_version_id' => $mail_version->id,
                            'user_id' => Auth::user()->id,
                            'target_user_id' => $secretary_data->id,
                            'type' => 'create',
                        ]);
                    }
                } else {
                    redirect('/');
                }
    }
}
