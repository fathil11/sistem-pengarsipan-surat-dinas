<?php

namespace App\Http\Controllers;

use App\Mail;
use App\User;
use App\MailLog;
use App\MailFile;
use App\MailType;
use App\MailFolder;
use App\MailVersion;
use App\MailPriority;
use App\UserPosition;
use App\MailReference;
use App\UserDepartment;
use App\MailTransaction;
use App\UserPositionDetail;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\MailOutRequest;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\UserPositionRequest;
use App\Http\Requests\UserDepartmentRequest;
use App\Http\Requests\UserPositionDetailRequest;

class FathilTestingController extends Controller
{
    public function storeMailOut(MailOutRequest $request)
    {
        // Validate Form
        $request->validated();

        // Check Mail Attribute is exists
        if (!$this->checkMailAttributeIsExists(
            $request->mail_folder_id,
            $request->mail_type_id,
            $request->mail_reference_id,
            $request->mail_priority_id
        )) {
            return response(404);
        }

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
            'version' => 0,
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
        $user = User::findOrFail(Auth::user()->id);
        $user_role = $user->getRole();

        // Check User role is admin || kepala_dinas
        if ($user_role == 'admin' || $user_role == 'kepala_dinas') {
            // Target User role always kepala_tu
            $target_user_position = 'Kepala TU';

            // Get Users with role kepala_tu
            $target_user = User::select('id')->withPosition($target_user_position)->first();
        } else {
            $target_user_position = UserPosition::getTopPosition($user_role);

            // Check if authenticated User role is has Extra
            if ($user_role == 'kepala_seksie') {
                $user_department = $user->getDepartment();
                // Set target user id with same department
                $target_user = User::select('id')
                ->where(function ($query) use ($target_user_position) {
                    $query->withPosition($target_user_position);
                })
                ->where(function ($query) use ($user_department) {
                    $query->withDepartment($user_department);
                })
                ->first();
            } else {
                // Set target user id without department
                $target_user = User::select('id')
                ->withPosition($target_user_position)->first();
            }
        }

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

    public function updateMailOut(MailOutRequest $request, $id)
    {
        // Validate Form
        $request->validated();

        // Check Mail is exists and kind of mail out
        $mail = Mail::findOrFail($id)->mailVersions;
        if ($mail->kind != 'in') {
            return abort(403);
        }
        // Assigning User
        $user = User::find(Auth::user()->id);
        $user_id = $user->id;

        // Get latest MailVersion id
        $last_mail_version_id = $mail->mailVersions->last()->id;

        // Check user is authorized for updating EmailOut
        $update_transaction_request = MailTransaction::where([
            ['mail_version_id', $last_mail_version_id],
            ['target_user_id', $user_id],
            ['type', 'correction']
        ])->first();

        if ($update_transaction_request == null) {
            return response(403);
        }

        // Check Mail Attribute is exists
        if (!$this->checkMailAttributeIsExists(
            $request->mail_folder_id,
            $request->mail_type_id,
            $request->mail_reference_id,
            $request->mail_priority_id
        )) {
            return response(404);
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
            'version' => 0,
        ]);

        // Check File, if exist Create MailFile
        if (request()->has('file')) {
            // Create & Store Mail File
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

        //// Create MailTransaction
        //// $update_transaction_request->user->getRole();

        // Assign authenticated user
        $user_role = $user->getRole();

        $user_top_role = UserPosition::getTopRole($user);

        // Check if authenticated User role is kasie
        if ($user_role == 'kepala_seksie') {
            $user_department = $user->getDepartment();

            // Get Users ids
            // with role = user_top_role
            // with department = same department with user
            $target_user_ids = User::select('id')
                ->where(function ($query) use ($user_top_role) {
                    $query->withRole($user_top_role);
                })
                ->where(function ($query) use ($user_department) {
                    $query->withDepartment($user_department);
                })
                ->get();
        } else {
            $target_user_ids = User::select('id')
                ->withRole($user_top_role)->get();
        }

        // Add Corrected Log to Editor
        MailLog::create([
            'mail_transaction_id' => $update_transaction_request->id,
            'log' => 'corrected'
        ]);

        $mail_transaction = MailTransaction::where([
        ['mail_version_id', $last_mail_version_id],
        ['type', 'correction']
        ])->whereHas('userTarget', function (Builder $query) {
            return $query->whereHas('position', function (Builder $query) {
                return $query->where('role', 'kepala_seksie');
            })->whereHas('department', function (Builder $query) {
                return $query->where('department', 'Ilmu Pengetahuan dan Teknologi');
            });
        })->get();

        // Create & Process (Mail Transaction)
        foreach ($target_user_ids as $target_user_id) {
            $mail_transaction = MailTransaction::create([
                'mail_version_id' => $mail_version->id,
                'user_id' => $user->id,
                'target_user_id' => $target_user_id->id,
                'type' => 'send'
            ]);

            MailLog::create([
                'mail_transaction_id' => $mail_transaction->id,
                'log' => 'delivered'
            ]);
        }
    }

    public function checkMailAttributeIsExists(
        $mail_folder_id,
        $mail_priority_id,
        $mail_type_id,
        $mail_reference_id
    ) {
        return MailFolder::find($mail_folder_id)->exists() &&
            MailPriority::find($mail_priority_id)->exists() &&
            MailType::find($mail_type_id)->exists() &&
            MailReference::find($mail_reference_id)->exists();
    }

    public function temp()
    {
        $types = MailType::all('type');
        $types = $types->toArray();
        dd($types);
    }
}
