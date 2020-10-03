<?php

namespace App\Http\Controllers;

use App\Mail;
use App\MailType;
use App\MailFolder;
use App\MailVersion;
use App\MailPriority;
use App\MailReference;
use App\MailCorrection;
use App\MailLog;
use App\MailTransaction;
use Illuminate\Http\Request;
use App\Repository\MailRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MailOutRequest;
use App\Services\Mail\MailOutService;

class MailOutController extends Controller
{
    /**
        Mail Out Controller
        Available functions :
            1.  index => Show list of Mail Out
            2.  create => Show create Mail Out
            3.  store => Store Mail Out
            4.  show => Show Mail Out
            5.  edit => Show Edit Mail Out (Show correct Mail Out)
            6.  update => Update Mail Out (correct Mail Out)
            7.  destroy => Delete Mail Out
            8.  archive => Archive Mail Out
            9.  download => Download Mail Out
            10. forward => Mail Out response (Accept)
            11. createCorrection => Mail Out response (Not Accept/Need Correction) (Store & Forward Mail Out Correction)
            12. storeNumber => Store Mail Out Number & Code
    */

    // Show Mail Out List
    public function index(MailRepository $mail_repository)
    {
        $mail_kind = 'out';
        $mails = $mail_repository->getMailData($mail_kind);
        return view('app.mails.mail-list', compact(['mails', 'mail_kind']));
    }

    // Show Create Mail Out
    public function create()
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

    // Store Mail Out
    public function store(MailOutRequest $request)
    {
        // Validate Form
        $request->validated();

        if (!MailOutService::store($request)) {
            return redirect('/surat/keluar')->with('errors', 'Gagal menambahkan surat keluar.');
        }

        return redirect('/surat/keluar')->with('success', 'Berhasil menambahkan surat keluar.');
    }

    // Show Mail Out
    public function show(MailRepository $mail_repository, $id)
    {
        $mail = Mail::findOrFail($id);

        // Check user is authorized for updating EmailOut
        $mail = $mail_repository->getMailData('out', false, $id)->first();

        if ($mail == null) {
            return abort(403, 'Anda tidak punya akses');
        }

        $mail_extra['correction_type'] = $this->getMailExtra($mail);

        return view('app.mails.mail-view', compact(['mail', 'mail_extra']));
    }

    // Show Edit Mail Out
    public function edit($id)
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

    // Update Mail Out
    public function update(MailOutRequest $request, $id)
    {
        if (MailOutService::update($request, $id)) {
            return redirect('/surat/keluar')->with('success', 'Berhasil mengubah surat.');
        }
        return abort(404);
    }

    // Delete Mail Out
    public function destroy($id)
    {
        $mail = Mail::findOrFail($id);
        $mail->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus data');
    }

    // Archive Mail Out
    public function archive($id)
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

    // Download Mail Out
    public function download($id)
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

    // Mail Out action : Forward (Accept)
    public function forward($id)
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

    // Mail Out action : Make Correction (Not Accept)
    public function createCorrection(Request $request, $transaction_id)
    {
        $transaction = MailTransaction::findOrFail($transaction_id);
        $current_transaction = MailTransaction::create([
            'mail_version_id' => $transaction->mail_version_id,
            'user_id' => Auth::id(),
            'target_user_id' => $transaction->user_id,
            'type' => 'correction'
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
            // 'mail_correction_type_id' => $request->mail_correction_type_id,
            'note' => $request->note,
        ]);

        return redirect('/surat/keluar')->with('success', 'Berhasil membuat koreksi surat.');
    }

    // Store Mail Out Number
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
}
