<?php

namespace App\Http\Controllers;

use App\Mail;
use App\MailTransaction;
use App\User;
use App\Repository\MailRepository;
use App\UserDepartment;
use App\UserPosition;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class FathilTestingController extends Controller
{
    public function showDashboard()
    {
        return view('app.dashboard');
    }

    public function showMailOutList()
    {
        $mail_repository = new MailRepository();
        Auth::login(User::find(8));
        $mail_kind = 'out';
        $mails = $mail_repository->getMailData($mail_kind);
        return view('app.mails.mail-list', compact(['mails', 'mail_kind']));
    }

    public function showMailInList()
    {
        $mail_repository = new MailRepository();
        Auth::login(User::find(8));
        $mail_kind = 'in';
        $mails = $mail_repository->getMailData($mail_kind);
        return view('app.mails.mail-list', compact(['mails', 'mail_kind']));
    }

    public function showMailOut($id)
    {
        Auth::login(User::find(8));
        $mail = Mail::findOrFail($id);

        // Check user is authorized for updating EmailOut
        $mail = (new MailRepository)->getMailData('out', false, $id)->first();

        if ($mail == null) {
            return abort(403, 'Anda tidak punya akses');
        }
        return view('app.mails.mail-view', compact('mail'));
    }

    public function downloadMailOut($id)
    {
        $mail = (new MailRepository)->getMailData('out', false, $id)->first();
        $file_name = $mail->file->original_name . '.' . $mail->file->type;
        return response()->download(storage_path('app').'\documents\testing.sql', $file_name);
    }

    public function test()
    {
    }
}
