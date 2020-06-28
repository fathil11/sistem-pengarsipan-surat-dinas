<?php

namespace App\Http\Controllers;

use App\Mail;

//Mail Out Privileges
use App\User;
use App\MailLog;

//Mail In Privileges
use App\MailType;
use App\MailFolder;
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

    // Show Mail Out List
    public function showMailOutList()
    {
        //== Auth For Testing
        // /** @var App\User $user */
        // Auth::login(User::find(6));

        $mail_repository = new MailRepository();
        $mail_kind = 'out';
        $mails = $mail_repository->getMailData($mail_kind);

        return view('app.mails.mail-list', compact(['mails', 'mail_kind']));
    }

    // Show Mail Out
    public function showMailOut($id)
    {
        //== Auth For Testing
        // /** @var App\User $user */
        // Auth::login(User::find(6));

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

    // View Store Mail Out
    public function showCreateMailOut()
    {
        //== Auth For Testing
        // /** @var App\User $user */
        // Auth::login(User::find(6));

        /** @var App\User $Auth */
        if (Auth::user()->isTU()) {
            return abort(403, 'Anda tidak memiliki akses');
        }

        $mail_extra['type'] = MailType::all();
        $mail_extra['reference'] = MailReference::all();
        $mail_extra['priority'] = MailPriority::all();
        $mail_extra['folder'] = MailFolder::all();
        $mail_kind = 'keluar';
        return view('app.mails.mail-create', compact(['mail_extra', 'mail_kind']));
    }

    // View Store Mail In
    public function showCreateMailIn()
    {
        //== Auth For Testing
        // /** @var App\User $user */
        // Auth::login(User::find(6));

        /** @var App\User $Auth */
        if (!Auth::user()->isTU()) {
            return abort(403, 'Anda tidak memiliki akses');
        }

        $mail_extra['type'] = MailType::all();
        $mail_extra['reference'] = MailReference::all();
        $mail_extra['priority'] = MailPriority::all();
        $mail_extra['folder'] = MailFolder::all();
        $mail_kind = 'masuk';

        return view('app.mails.mail-create', compact(['mail_extra', 'mail_kind']));
    }

    // Store Mail Out
    public function storeMailOut(MailOutRequest $request)
    {
        return MailOutService::store($request);
    }

    // Show Update Mail Out
    public function showUpdateMailOut($id)
    {
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

    // Forward Mail Out
    public function forwardMailOut($id)
    {
        if (MailOutService::forward($id) == true) {
            return redirect('/surat/keluar')->with('success', 'Berhasil meneruskan surat.');
        }
        return abort(403, 'Anda tidak punya akses.');
    }

    // Create Correction Mail Out
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

    // Update Mail Out
    public function updateMailOut(MailOutRequest $request, $id)
    {
        if (MailOutService::update($request, $id)) {
            return redirect('/surat/keluar')->with('success', 'Berhasil mengubah surat.');
        }
        return abort(404);
    }

    // Download Mail Out
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

    // Delete Mail Out
    public function deleteMailOut($id)
    {
        return MailOutService::delete($id);
    }



    // === Mail In Privileges ===
    public function showMailInList()
    {
        //== Auth For Testing
        // /** @var App\User $user */
        // Auth::login(User::find(2));

        $mail_repository = new MailRepository();

        $mail_kind = 'in';
        $mails = $mail_repository->getMailData($mail_kind);
        return view('app.mails.mail-list', compact(['mails', 'mail_kind']));
    }

    public function showMailIn($id)
    {
        // /** @var App\User $user */
        // Auth::login(User::find(6));
        $mail = Mail::findOrFail($id);

        // Check user is authorized for updating EmailOut
        $mail = (new MailRepository)->getMailData('in', false, $id)->first();

        if ($mail == null) {
            return abort(403, 'Anda tidak punya akses');
        }
        return view('app.mails.mail-view', compact('mail'));
    }

    public function storeMailIn(MailInRequest $request)
    {
        return MailInService::store($request);
    }

    public function updateMailIn(MailInRequest $request, $id)
    {
        return MailInService::update($request, $id);
    }

    public function deleteMailIn($id)
    {
        return MailInService::delete($id);
    }

    public function downloadMailIn($id)
    {
        return MailInService::download($id);
    }

    public function showProcessMailIn($id)
    {
        return MailInService::showProccess($id);
    }

    public function forwardMailIn(MailMemoRequest $request, $id)
    {
        return MailInService::forward($request, $id);
    }

    public function dispositionMailIn(MailMemoRequest $request, $id)
    {
        return MailInService::disposition($request, $id);
    }

    public function downloadDispositionMailIn($id)
    {
        return MailInService::downloadDisposition($id);
    }

    public function showAddCodeMailOut($id)
    {
        $mail = Mail::findOrFail($id);

        if (!Auth::user()->isTU()) {
            return abort(404);
        }

        return view('');
    }
}
