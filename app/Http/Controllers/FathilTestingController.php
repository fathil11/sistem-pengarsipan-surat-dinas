<?php

namespace App\Http\Controllers;

use App\Mail;
use App\User;
use App\MailLog;
use App\MailType;
use App\MailFolder;
use App\MailPriority;
use App\UserPosition;
use App\MailReference;
use App\UserDepartment;
use App\MailTransaction;
use Illuminate\Http\Request;
use App\Repository\MailRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MailOutRequest;
use App\MailCorrection;
use App\MailCorrectionType;
use App\Services\Mail\MailOutService;
use Illuminate\Database\Eloquent\Builder;
use Log;

class FathilTestingController extends Controller
{
    public function showDashboard()
    {
        return view('app.dashboard');
    }
}
