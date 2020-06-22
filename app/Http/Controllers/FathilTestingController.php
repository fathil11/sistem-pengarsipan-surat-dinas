<?php

namespace App\Http\Controllers;

use App\Mail;
use App\MailFile;
use App\MailVersion;
use App\UserDepartment;
use App\UserPosition;
use Illuminate\Http\Request;

class FathilTestingController extends Controller
{
    private $roles = [
    'admin',
    'kepala_dinas',
    'sekretaris',
    'kepala_bidang',
    'kepala_seksie',
    'kepala_tu'
    ];

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

        // === Validation ===
        $request->validate([
            'title' => 'required|min:3|max:50',
            'mail_folder_id' => 'required|numeric|min:1|max:255',
            'mail_type_id' => 'required|numeric|min:1|max:255',
            'mail_reference_id' => 'required|numeric|min:1|max:255',
            'mail_priority_id' => 'required|numeric|min:1|max:255',
            'mail_created_at' => 'required|date',
            'file' => 'required|file|mimes:pdf,doc,docx,jpeg,jpg,png|size:5120',
        ]);

        // === Create (Mail) ===
        $mail = Mail::create([
            'kind' => 'out',
            'title' => $request->title,
            'origin' => 'Internal',
            'mail_folder_id' => $request->mail_folder_id,
            'mail_type_id' => $request->mail_type_id,
            'mail_reference_id' => $request->mail_reference_id,
            'mail_priority_id' => $request->mail_priority_id
        ]);

        // === Create & Assign (Mail Version) ===
        $mail_version = MailVersion::create([
            'mail_id' => $mail->id,
            'version' => '1',
        ]);

        // === Create & Store File (Mail File) ===
        $file = $request->file('file');
        $mail_file = MailFile::create([
            'mail_version_id' => $mail_version->id,
            'original_name' => $file->getClientOriginalName(),
            'directory_name' => $file->store('documents'),
            'type' => $file->getClientOriginalExtension(),
        ]);

        // === Create & Process (Mail Transaction) ===
        // $mail_transaction =
    }

    public function storeUserPosition(Request $request)
    {
        // === Validate Form ===
        $request->validate([
            'position' => 'required|min:3|max:50',
            'role' => 'required|min:3|max:50'
        ]);

        // === Check Role format is Correct ===
        if (!in_array($request->role, $this->roles)) {
            return redirect()->back()->withErrors('Format akses tidak sesuai !');
        }

        // === Create UserPosition ===
        UserPosition::create([
            'position' => $request->position,
            'role' => $request->role
        ]);

        return response(200);
    }

    public function storeUserDepartment(Request $request)
    {
        // === Validate Form ===
        $request->validate([
            'department' => 'required|min:3|max:50',
            'department_abbreviation' => 'required|min:2|max:50',
        ]);

        // === Create UserDepartment ===
        UserDepartment::create([
            'department' => $request->department,
            'department_abbreviation' => $request->department_abbreviation
        ]);

        return response(200);
    }

    public function storeUserPositionDetail(Request $request)
    {
    }
}
