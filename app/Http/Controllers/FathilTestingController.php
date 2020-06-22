<?php

namespace App\Http\Controllers;

use App\Mail;
use App\MailFile;
use App\MailVersion;
use App\User;
use App\UserDepartment;
use App\UserPosition;
use App\UserPositionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        if (!UserPosition::checkRoleIsExists($request->role)) {
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
        // === Validate Form ===
        $request->validate([
            'position_detail' => 'required|min:3|max:50',
        ]);

        // === Create UserDepartment ===
        UserPositionDetail::create([
            'position_detail' => $request->position_detail,
        ]);

        return response(200);
    }

    public function storeUser(Request $request)
    {
        // === Validate Form ===
        $request->validate([
            'nip' => 'required|min:3|max:50',
            'name' => 'required|min:3|max:255',
            'user_position_id' => 'required|numeric|min:1|max:255',
            'user_department_id' => 'nullable|numeric|min:1|max:255',
            'user_position_detail_id' => 'nullable|numeric|min:1|max:255',
            'email' => 'required|min:5|max:255|email:rfc',
            'phone_number' => 'required|min:5|max:20',
            'username' => 'required|min:5|max:255',
            'password' => 'required|min:6|max:512',
        ]);

        // === Validate UserPosition is exist ===
        if (!UserPosition::checkPositionIdIsExists($request->user_position_id)) {
            return redirect()->back()->withErrors('Format jabatan tidak sesuai !');
        }

        // === Process UserDepartment & UserPositionDetails ===
        /*
        User with position role is Admin, Kepala Dinas, Sekretaris, or Kepala TU does't have UserDepartment and UserPositionDetail.
        */
        $user_department_id = null;
        $user_position_id = null;

        if (UserPosition::checkPositionIdHasExtra($request->user_position_id)) {
            $user_department_id = $request->user_department_id;
            $user_position_id = $request->user_position_id;
        }

        // === Create UserDepartment ===
        User::create([
            'nip' => $request->nip,
            'name' => $request->name,
            'user_position_id' => $request->user_position_id,
            'user_department_id' => $user_department_id,
            'user_position_detail_id' => $user_position_id,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return response(200);
    }
}
