<?php

namespace App\Http\Controllers;

use App\Mail;

//Mail Out Privileges
use App\User;
use App\MailLog;

//Mail In Privileges
use App\MailType;
use App\MailFolder;
use App\MailVersion;
use App\MailPriority;
use App\MailReference;
use App\MailCorrection;
use App\MailTransaction;
use App\MailCorrectionType;
use Illuminate\Http\Request;
use App\Repository\MailRepository;
use App\Http\Requests\MailInRequest;
use App\Services\Mail\MailInService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MailOutRequest;
use App\Services\Mail\MailOutService;
use App\Http\Requests\MailMemoRequest;

class MailController extends Controller
{
    // === Mail Out Privileges ===
    private function getMailExtra($mail)
    {
        if ($mail->transaction == 'income' && ($mail->status['status'] == 'Perlu Tanggapan')) {
            return MailCorrectionType::all();
        }
        return null;
    }
}
