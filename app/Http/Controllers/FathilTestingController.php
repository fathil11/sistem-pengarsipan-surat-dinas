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

    public function showMailOutList()
    {
        $mail_repository = new MailRepository();
        Auth::login(User::find(2));
        $mail_kind = 'out';
        $mails = $mail_repository->getMailData($mail_kind);

        return view('app.mails.mail-list', compact(['mails', 'mail_kind']));
    }

    public function showMailInList()
    {
        $mail_repository = new MailRepository();
        /** @var App|User  */
        Auth::login(User::find(2));
        $mail_kind = 'in';
        $mails = $mail_repository->getMailData($mail_kind);
        return view('app.mails.mail-list', compact(['mails', 'mail_kind']));
    }

    public function showMailOut($id)
    {
        Auth::login(User::find(2));
        $mail = Mail::findOrFail($id);
        // Check user is authorized for updating EmailOut
        $mail = (new MailRepository)->getMailData('out', false, $id)->first();
        if ($mail == null) {
            return abort(403, 'Anda tidak punya akses');
        }

        $mail_extra = null;
        if ($mail->transaction == 'income' && $mail->status['action'] == 'buat-koreksi') {
            $mail_extra['correction_type'] = MailCorrectionType::all();
        }
        return view('app.mails.mail-view', compact(['mail', 'mail_extra']));
    }

    public function downloadMailOut($id)
    {
        $mail = (new MailRepository)->getMailData('out', false, $id)->first();
        $file_mime = '.' . $mail->file->type;
        $file_stored = $mail->file->directory_name . '.' . $mail->file->type;
        $file_name = $mail->file->original_name . $file_mime;

        MailLog::create([
            'mail_transaction_id' => $mail->transaction_id,
            'log' => 'download',
            'user_id' => Auth::id(),
        ]);

        return response()->download(storage_path('app').'\documents\\'.$file_stored, $file_name);
    }

    public function showMailOutCorrection($id)
    {
        // dd(session('errors'));
        $mail = Mail::findOrFail($id);
        $mail = (new MailRepository)->getMailData('out', false, $id)->first();

        if ($mail->transaction != 'income' || $mail->status['action'] != 'koreksi') {
            return abort(403, 'Anda tidak punya akses');
        }

        $mail_extra['type'] = MailType::all();
        $mail_extra['reference'] = MailReference::all();
        $mail_extra['priority'] = MailPriority::all();
        $mail_extra['folder'] = MailFolder::all();

        return view('app.mails.mail-out-update', compact(['mail', 'mail_extra']));
    }

    public function updateMailOut(MailOutRequest $request, $id)
    {
        if (MailOutService::update($request, $id)) {
            return redirect('/surat/keluar')->with('success', 'Berhasil mengubah surat.');
        }
        return abort(404);
    }

    public function createCorrection(Request $request, $transaction_id)
    {
        $transaction = MailTransaction::findOrFail($transaction_id);
        $current_transaction = MailTransaction::create([
            'mail_version_id' => $transaction->mail_version_id,
            'user_id' => Auth::id(),
            'target_user_id' => $transaction->user_id,
        ]);

        MailLog::create([
            'mail_transaction_id' => $transaction->id,
            'log' => 'correction',
            'user_id' => Auth::id()
        ]);

        MailLog::create([
            'mail_transaction_id' => $current_transaction->id,
            'log' => 'correction',
            'user_id' => Auth::id()
        ]);

        MailCorrection::create([
            'mail_transaction_id' => $current_transaction->id,
            'mail_correction_type_id' => $request->mail_correction_type_id,
            'note' => $request->note,
        ]);

        return redirect('/surat/keluar')->with('success', 'Berhasil membuat koreksi surat.');
    }

    public function forwardMailOut($id)
    {
        if (MailOutService::forward($id) == true) {
            return redirect('/surat/keluar')->with('success', 'Berhasil meneruskan surat.');
        }
        // }
    }
}
