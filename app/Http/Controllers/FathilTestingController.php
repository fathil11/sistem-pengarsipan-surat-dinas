<?php

namespace App\Http\Controllers;

use App\Http\Requests\MailOutRequest;
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
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\UserPositionRequest;
use App\Http\Requests\UserDepartmentRequest;
use App\Http\Requests\UserPositionDetailRequest;
use App\MailLog;
use App\MailTransaction;

class FathilTestingController extends Controller
{
    public function storeMailOut(MailOutRequest $request)
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
            'mail_priority_id' => $request->mail_priority_id
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
            $target_user_role = 'kepala_tu';

            // Get Users with role kepala_tu
            $target_user_ids = User::select('id')->withRole($target_user_role)->get();
        } else {
            // Get top role order
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
        }

        // Create & Process (Mail Transaction)
        foreach ($target_user_ids as $target_user_id) {
            $mail_transaction = MailTransaction::create([
                'mail_version_id' => $mail_version->id,
                'user_id' => $user->id,
                'target_user_id' => $target_user_id->id,
                'type' => 'create'
            ]);

            MailLog::create([
                'mail_transaction_id' => $mail_transaction->id,
                'log' => 'delivered'
            ]);
        }

        return response(200);
    }

    public function updateMailOut(MailOutRequest $request, $id)
    {
        // Validate Form
        $request->validated();

        //
    }

    public function temp()
    {
        // $target_user_ids = User::select('id')
        // ->where(function ($query) {
        //     $query->withRole('kepala_bidang');
        // })
        // ->where(function ($query) {
        //     $query->withDepartment('Ilmu Pengetahuan dan Teknologi');
        // })
        // ->get();

        // dd($target_user_ids[0]->id);
    }
}
