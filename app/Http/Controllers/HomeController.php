<?php

namespace App\Http\Controllers;

use App\Mail;
use Illuminate\Http\Request;
use App\Repository\MailRepository;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function showDashboard(MailRepository $mail_repository)
    {
        $stat['mail_in'] = $mail_repository->getMailData('in')->count();
        $stat['mail_out'] = $mail_repository->getMailData('out')->count();
        $stat['mail_total'] = $stat['mail_in'] + $stat['mail_out'];

        return view('app.dashboard', compact('stat'));
    }
}
