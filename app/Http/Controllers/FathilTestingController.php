<?php

namespace App\Http\Controllers;

use App\Mail;
use App\User;
use App\MailFile;
use App\MailVersion;
use App\UserPosition;
use App\UserDepartment;
use App\UserPositionDetail;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserPositionRequest;
use App\Http\Requests\UserDepartmentRequest;
use App\Http\Requests\UserPositionDetailRequest;

class FathilTestingController extends Controller
{
    public function storeMailOut(Request $request)
    {
        // TODO:
        /*
            - Mail
            - Mail File

            === Query ===
            - Create mail
            - Create mail version
            - Create mail file
            - Create mail transaction
                - mail_version_id -> mail version created id
                - user_id -> auth
                - target_user_id -> Condition based on user role
                - type -> Condition based on user role

        */

        // Validation
        $request->validate([
            'title' => 'required|min:3|max:50',
            'mail_folder_id' => 'required|numeric|min:1|max:255',
            'mail_type_id' => 'required|numeric|min:1|max:255',
            'mail_reference_id' => 'required|numeric|min:1|max:255',
            'mail_priority_id' => 'required|numeric|min:1|max:255',
            'mail_created_at' => 'required|date',
            'file' => 'required|file|mimes:pdf,doc,docx,jpeg,jpg,png|size:5120',
        ]);

        // Create (Mail)
        $mail = Mail::create([
            'kind' => 'out',
            'title' => $request->title,
            'origin' => 'Internal',
            'mail_folder_id' => $request->mail_folder_id,
            'mail_type_id' => $request->mail_type_id,
            'mail_reference_id' => $request->mail_reference_id,
            'mail_priority_id' => $request->mail_priority_id
        ]);

        // Create & Assign (Mail Version)
        $mail_version = MailVersion::create([
            'mail_id' => $mail->id,
            'version' => '1',
        ]);

        // Create & Store File (Mail File)
        $file = $request->file('file');
        $mail_file = MailFile::create([
            'mail_version_id' => $mail_version->id,
            'original_name' => $file->getClientOriginalName(),
            'directory_name' => $file->store('documents'),
            'type' => $file->getClientOriginalExtension(),
        ]);

        $target_user_id = 'tes';

        // Create & Process (Mail Transaction)
        $mail_transaction = Mail::create([
            'mail_version_id' => $mail_version->id,
            'user_id' => Auth::user()->id,
            'target_user_id' => $target_user_id,
            'type' => 'create'
        ]);
    }
}
