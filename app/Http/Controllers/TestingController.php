<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

use Illuminate\Support\Facades\DB;
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

    public function showMailArchiveYear()
    {
        $mails = Mail::select(DB::raw('YEAR(mail_created_at) as year'))->where('status', 'archive')->orderBy('mail_created_at')->distinct()->get();
        $years = $mails->pluck('year');
        return view('app.mails.archive-mail-year-list')->with(compact('years'));
    }

    public function showMailArchive($year)
    {
        if(strtolower($year) == 'semua')
        {
            $mails = Mail::with('type', 'reference', 'priority')->where('status', 'archive')->orderBy('mail_created_at')->get();
        } else {
            $mails = Mail::with('type', 'reference', 'priority')->whereYear('mail_created_at', $year)->where('status', 'archive')->orderBy('mail_created_at')->get();
        }
        return view('app.mails.archive-mail-list')->with(compact('mails'));
    }

    public function tes()
    {
        return response(200);
    }
}

