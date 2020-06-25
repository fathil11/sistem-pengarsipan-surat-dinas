<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

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
    public function forwardMailIn(Request $request, $id){
        $mail = Mail::findOrFail($id);
        if ($mail->kind != 'in'){
            return response(403);
        }
        $user = User::select('id')->findOrFail(Auth::user()->id);
        $mail_version_last = $mail->mailVersions->last();
        $last_mail_transaction_is_memo = $mail_version_last->mailTransactions->where('type', 'memo')->isNotEmpty();
        $last_mail_transaction_is_disposition = $mail_version_last->mailTransactions->where('type', 'archive')->isNotEmpty();
        // $mail_log_last = $mail_transaction_last->transactionLog->last();

        if ($last_mail_transaction_is_memo || $last_mail_transaction_is_disposition){
            return redirect('/');
        }

        $request->validate([
            'memo' => 'required|min:3|max:1000',
        ]);

        $target_user = User::select('id')->withPosition('Kepala Dinas')->first();

        $mail_transaction = MailTransaction::create([
            'mail_version_id' => $mail_version_last->id,
            'user_id' => $user->id,
            'target_user_id' => $target_user->id,
            'type' => 'memo',
        ]);

        MailMemo::create([
            'mail_transaction_id' => $mail_transaction->id,
            'memo' => $request->memo,
        ]);

        MailLog::create([
            'mail_transaction_id' => $mail_transaction->id,
            'log' => 'send',
        ]);
    }

    public function dispositionMailIn(Request $request, $id){
        $mail = Mail::findOrFail($id);
        if ($mail->kind != 'in'){
            return response(403);
        }

        $user = User::select('id')->findOrFail(Auth::user()->id);
        $mail_version_last = $mail->mailVersions->last();
        $mail_transaction_last = $mail_version_last->mailTransactions->where('target_user_id', $user->id)->last();
        $last_mail_transaction_isnt_memo = $mail_version_last->mailTransactions->where('type', 'memo')->isEmpty();
        $mail_has_disposition = $mail_version_last->mailTransactions->where('type', 'archive')->isNotEmpty();

        if ($last_mail_transaction_isnt_memo || $mail_has_disposition){
            return redirect('/');
        }

        $request->validate([
            'memo' => 'required|min:3|max:1000',
        ]);

        $target_user = User::select('id')->withPosition('Kepala Bidang')->first();

        $mail_transaction = MailTransaction::create([
            'mail_version_id' => $mail_version_last->id,
            'user_id' => $user->id,
            'target_user_id' => $target_user->id,
            'type' => 'archive',
        ]);

        MailMemo::create([
            'mail_transaction_id' => $mail_transaction->id,
            'memo' => $request->memo,
        ]);

        MailLog::create([
            'mail_transaction_id' => $mail_transaction->id,
            'log' => 'send',
        ]);


        //=== Create & Download File Disposisi ===
        // $secretary_memo = $mail_transaction_last->transactionMemo->memo;
        // $kepala_dinas_memo = $request->memo;
        // dd($mail->title);
        // dump($kepala_dinas_memo);
        // dd($secretary_memo);




    }



    public function tes()
    {
        $mail_attribute = Mail::findOrFail(1);
        // $secretary_memo = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi, eos aut atque dolor laudantium perferendis. Vero tempore vel explicabo optio fugit, unde ex inventore cum necessitatibus tempora at nulla maxime.';
        // $hod_memo = 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi, eos aut atque dolor laudantium perferendis. Vero tempore vel explicabo optio fugit, unde ex inventore cum necessitatibus tempora at nulla maxime.';

        // $memo = new Collection();
        // $memo->secretary = $secretary_memo;
        // $memo->hod = $hod_memo;
        // $mail = new Collection();
        // $mail->mail = $mail_attribute;
        // $mail->memo = $memo;
        // $data['title'] = $mail_attribute->title;
        // // return view('disposition')->with(compact('mail'));
        // view()->share('mail_attribute',$mail_attribute);
        // $pdf = PDF::loadView('disposition', $mail_attribute)->setPaper('A4','potrait');
        // return $pdf->stream();
        // return $pdf->download('disposition.pdf');
        // dump($kepala_dinas_memo);
        // dd($secretary_memo);
        // return view('welcome');
        $pdf = PDF::loadView('tes')->setPaper('A4','potrait');
        return $pdf->download('tes.pdf');
    }
}

