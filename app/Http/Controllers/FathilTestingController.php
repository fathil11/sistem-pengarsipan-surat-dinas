<?php

namespace App\Http\Controllers;

use App\Mail;
use App\Repository\MailRepository;

class FathilTestingController extends Controller
{
    public function showDashboard()
    {
        return view('app.dashboard');
    }

    public function showMailOutList(MailRepository $mail_repository)
    {
        $mails = $mail_repository->getMailWithSameStakeHolder(8, 'out');
        return view('app.mails.mail-out-list', compact('mails'));
    }

    public function test()
    {
        // return Mail::find(10)->getStatus();
    }
}
