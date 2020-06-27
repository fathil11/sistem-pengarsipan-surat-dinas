<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

use Illuminate\Support\Facades\Storage;
use App\Repository\MailRepository;

use App\User;
use App\UserPosition;

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
    public function tes(MailRepository $trans)
    {
        $mail = Mail::findOrFail(1);
        $secretary_memo = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi, eos aut atque dolor laudantium perferendis. Vero tempore vel explicabo optio fugit, unde ex inventore cum necessitatibus tempora at nulla maxime.';
        $hod_memo = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi, eos aut atque dolor laudantium perferendis. Vero tempore vel explicabo optio fugit, unde ex inventore cum necessitatibus tempora at nulla maxime.';

        $memo = new Collection();
        $memo->secretary = $secretary_memo;
        $memo->hod = $hod_memo;
        $mail_attribute = new Collection();
        $mail_attribute->mail = $mail;
        $mail_attribute->memo = $memo;
        return view('pdf-example', ['mail' => $mail_attribute]);
        $pdf = PDF::loadView('pdf-example', ['mail' => $mail_attribute])->setPaper('A4','potrait');
        return $pdf->download('pdf-example.pdf');
    }
}

