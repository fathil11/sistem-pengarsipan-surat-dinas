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
        Auth::login(User::find(14));
        $mails = $mail_repository->getMailData('out');
        return view('app.mails.mail-out-list', compact('mails'));
    }

    public function test(MailRepository $trans)
    {
        Auth::login(User::find(8));
        $test = $trans->withSameStakeholder('out');
        // dd($test);
        // dd($test[6]->where('user_id', 8));
        // dd(UserDepartment::getDepartmentId('INFOKOM'));

        // return view('welcome');
    }
}
