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

    // Show Mail Out List
    public function showMailOutList(MailRepository $mail_repository)
    {
        $mail_kind = 'out';
        $mails = $mail_repository->getMailData($mail_kind);

        return view('app.mails.mail-list', compact(['mails', 'mail_kind']));
    }

    public function storeNumber(Request $request, $id)
    {
        if (!Auth::user()->isTU()) {
            return abort(403, 'Anda tidak punya akses');
        }

        $mail = Mail::findOrFail($id);
        $mail->code = $request->code;
        $mail->directory_code = $request->directory_code;
        $mail->save();
        return redirect('/surat/keluar')->with('success', 'Berhasil menambahkan nomor pada surat');
    }

    // Show Mail Out
    public function showMailOut(MailRepository $mail_repository, $id)
    {
        $mail = Mail::findOrFail($id);

        // Check user is authorized for updating EmailOut
        $mail = $mail_repository->getMailData('out', false, $id)->first();

        if ($mail == null) {
            return abort(403, 'Anda tidak punya akses');
        }

        $mail_extra = $this->getMailExtra($mail);

        return view('app.mails.mail-view', compact(['mail', 'mail_extra']));
    }

    // View Store Mail Out
    public function showCreateMailOut()
    {

        /** @var App\User $Auth */
        if (Auth::user()->isTU()) {
            return abort(403, 'Anda tidak memiliki akses');
        }

        $mail_kind = 'keluar';

        $mail_extra['type'] = MailType::all();
        $mail_extra['reference'] = MailReference::all();
        $mail_extra['priority'] = MailPriority::all();
        $mail_extra['folder'] = MailFolder::all();

        return view('app.mails.mail-create', compact(['mail_extra', 'mail_kind']));
    }

    // View Store Mail In
    public function showCreateMailIn()
    {

        /** @var App\User $Auth */
        if (!Auth::user()->isTU()) {
            return abort(403, 'Anda tidak memiliki akses');
        }

        $mail_kind = 'masuk';

        $mail_extra['type'] = MailType::all();
        $mail_extra['reference'] = MailReference::all();
        $mail_extra['priority'] = MailPriority::all();
        $mail_extra['folder'] = MailFolder::all();

        return view('app.mails.mail-create', compact(['mail_extra', 'mail_kind']));
    }

    // Store Mail Out
    public function storeMailOut(MailOutRequest $request)
    {
        // Validate Form
        $request->validated();

        if (!MailOutService::store($request)) {
            return redirect('/surat/keluar')->with('errors', 'Gagal menambahkan surat keluar.');
        }

        return redirect('/surat/keluar')->with('success', 'Berhasil menambahkan surat keluar.');
    }

    // Show Update Mail Out
    public function showUpdateMailOut(MailRepository $mail_repository, $id)
    {
        $mail = Mail::findOrFail($id);

        $mail = $mail_repository->getMailData('out', false, $id)->first();

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
        // Check if Mail Exists and Mail kind is 'out'
        $mail = Mail::findOrFail($id);

        if ($mail->kind != 'out') {
            return abort(403, 'Anda tidak punya akses.');
        }

        if (!MailOutService::forward($id)) {
            return abort(403, 'Anda tidak punya akses.');
        }

        return redirect('/surat/keluar')->with('success', 'Berhasil meneruskan surat.');
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
        $file_stored = $mail->file->directory_name;
        $file_name = $mail->file->original_name;

        MailLog::create([
            'mail_transaction_id' => $mail->transaction_id,
            'log' => 'download',
            'user_id' => Auth::id(),
        ]);

        return response()->download(storage_path('app').'/'.$file_stored, $file_name);
    }

    // Delete Mail Out
    public function deleteMail($id)
    {
        $mail = Mail::findOrFail($id);
        $mail->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus data');
    }



    // === Mail In Privileges ===
    public function showMailInList()
    {
        $mail_repository = new MailRepository();

        $mail_kind = 'in';
        $mails = $mail_repository->getMailData($mail_kind);
        return view('app.mails.mail-list', compact(['mails', 'mail_kind']));
    }

    public function showMailIn(MailRepository $mail_repository, $id)
    {
        // /** @var App\User $user */
        // Auth::login(User::find(1));
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
        // Validate Form
        $request->validated();
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

    public function archiveMailIn($id)
    {
        return MailInService::archive($id);
    }

    public function archiveMailOut($id)
    {
        if (!Auth::user()->isTU()) {
            return abort(403, 'Anda tidak memiliki akses');
        }

        $mail = Mail::findOrFail($id);
        $mail->status = 'archive';

        $mail_version_last = MailVersion::select('id')->where('mail_id', $mail->id)->get()->last();
        $transaction = MailTransaction::select('id')->where([
            ['mail_version_id', $mail_version_last->id],
        ])->first();

        MailLog::create([
            'mail_transaction_id' => $transaction->id,
            'log' => 'archived',
            'user_id' => Auth::id()
        ]);

        if ($mail->save()) {
            return redirect('/surat/keluar')->with('success', 'Berhasil mengarsipkan surat');
        }
    }

    private function getMailExtra($mail)
    {
        if ($mail->transaction == 'income' && $mail->status['action'] == 'buat-koreksi') {
            return $mail_extra['correction_type'] = MailCorrectionType::all();
        }
        return null;
    }
}
