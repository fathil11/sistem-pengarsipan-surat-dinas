<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

use Illuminate\Support\Facades\Storage;
use App\Repository\MailRepository;

use App\User;
use App\UserPosition;
use App\UserDepartment;

use App\Mail;
use App\MailVersion;
use App\MailFile;
use App\MailTransaction;
use App\MailLog;
use App\MailMemo;

use Carbon\Carbon;

use PDF;

class TestingController extends Controller
{
    public function showMailIn($id)
    {
        Auth::login(User::find(6));
        $mail = Mail::findOrFail($id);

        // Check user is authorized for updating EmailOut
        $mail = (new MailRepository)->getMailData('in', false, $id)->first();

        if ($mail == null) {
            return abort(403, 'Anda tidak punya akses');
        }
        return view('app.mails.mail-view', compact('mail'));
    }

    public function showProcessMailIn($id)
    {
        Auth::login(User::find(2));
        $mail = Mail::findOrFail($id);

        // Check user is authorized for updating EmailOut
        $mail = (new MailRepository)->getMailData('in', false, $id)->first();

        $user_departments = UserDepartment::get();

        if ($mail == null) {
            return abort(403, 'Anda tidak punya akses');
        }

        $user = User::with('position')->where('id', Auth::id())->first();
        if($user->getRole() == 'sekretaris')
        {
            return view('app.mails.mail-in.forward')->with(compact('mail', 'user_departments'));
        }
        else if($user->getRole() == 'kepala_dinas')
        {
            return view('app.mails.mail-in.disposition')->with(compact('mail', 'user_departments'));
        }
        return redirect('/surat/masuk');
    }

    public function tes()
    {
        //Check if Mail Exists and Mail kind is 'out'
        $mail = Mail::findOrFail(6);

        //Get Last Mail Version
        $mail_version_last = $mail->mailVersions->last();

        $last_mail_transaction = $mail_version_last->mailTransactions->last();
        //Check if Last Mail Transaction type isn't 'corrected' or 'create'
        $last_mail_transaction_isnt_corrected = $mail_version_last->mailTransactions->where('type', 'corrected')->isEmpty();
        $last_mail_transaction_isnt_create = $mail_version_last->mailTransactions->where('type', 'create')->isEmpty();

        //Redirect if Last Mail Transaction type isn't 'corrected' or 'create'
        if ($last_mail_transaction_isnt_corrected || $last_mail_transaction_isnt_create){
            return redirect('/');
        }

        // Assign authenticated user
        /** @var App\User $user */
        $user = User::find(8);
        // dd($user->position->position);
        $target_user = $user->getTopPosition();
        dd($target_user->position->position);
        // Create & Process (Mail Transaction)
        $mail_transaction = MailTransaction::create([
            'mail_version_id' => $mail_version_last->id,
            'user_id' => $user->id,
            'target_user_id' => $target_user->id,
            'type' => 'forward'
        ]);

        MailLog::create([
            'mail_transaction_id' => $mail_transaction->id,
            'log' => 'send',
            'user_id' => $user->id
        ]);

        return response(200);
    }
}

