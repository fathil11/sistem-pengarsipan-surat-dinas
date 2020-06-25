<?php

namespace App\Http\Controllers;

use App\Mail;
use App\User;
use App\MailLog;
use App\MailFile;
use Carbon\Carbon;
use App\MailVersion;
use App\UserPosition;
use App\MailTransaction;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MailOutRequest;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Builder;

class FathilTestingController extends Controller
{
    public function temp()
    {
    }
}
