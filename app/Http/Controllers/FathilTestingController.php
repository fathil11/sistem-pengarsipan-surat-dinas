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

    public function showMailOutList(MailRepository $mail_repository)
    {
        Auth::login(User::find(14));
        $mails['incoming'] = $mail_repository->getMailData('out', true);
        $mails['outcoming'] = $mail_repository->getMailData('out', false);
        return view('app.mails.mail-out-list', compact('mails'));
    }

    public function test(MailRepository $trans)
    {
        Auth::login(User::find(14));
        $test = $trans->withSameStakeholder('in', true);
        // dd($test[6]->where('user_id', 8));
        // dd(UserDepartment::getDepartmentId('INFOKOM'));

        // return view('welcome');
    }
}
