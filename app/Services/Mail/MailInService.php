<?php

namespace App\Services\Mail;

use PDF;

use App\Mail;
use App\User;

use App\MailLog;
use App\MailFile;
use App\MailMemo;
use App\MailVersion;
use App\UserDepartment;
use App\MailTransaction;
use App\Mail\Notification;

use App\Repository\MailRepository;

use App\Http\Requests\MailInRequest;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\MailMemoRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail as Mailer;

class MailInService
{
    // Read/Show Mail
    public static function show($id)
    {
        // Check user is authorized for updating EmailOut
        $mail = (new MailRepository)->getMailData('in', false, $id)->first();

        if ($mail == null) {
            return abort(403, 'Anda tidak punya akses');
        }
        return view('app.mails.mail-view', compact('mail'));
    }

    // Store Mail In
    public static function store($request)
    {


        //Create Mail
        $mail = Mail::create([
            'kind' => 'in',
            'directory_code' => $request->directory_code,
            'code' => $request->code,
            'title' => $request->title,
            'origin' => $request->origin,
            'mail_folder_id' => $request->mail_folder_id,
            'mail_type_id' => $request->mail_type_id,
            'mail_reference_id' => $request->mail_reference_id,
            'mail_priority_id' => $request->mail_priority_id,
            'mail_created_at' => $request->mail_created_at,
        ]);

        //Initialize Mail Version
        $mail_version = MailVersion::create([
            'mail_id' => $mail->id,
        ]);

        //Storing Mail File
        $file = $request->file('file');
        $mailFile = MailFile::create([
            'mail_version_id' => $mail_version->id,
            'original_name' => $file->getClientOriginalName(),
            'directory_name' => $file->store('documents'),
            'type' => $file->getClientOriginalExtension(),
        ]);

        //Initialize Mail Transaction to Secretary
        $user_id = Auth::id();
        $target_user = User::select(['id', 'email'])->withPosition('Sekretaris')->first();

        $mail_transaction = MailTransaction::create([
            'mail_version_id' => $mail_version->id,
            'user_id' => $user_id,
            'target_user_id' => $target_user->id,
            'type' => 'create',
        ]);

        //Create Log
        MailLog::create([
            'mail_transaction_id' => $mail_transaction->id,
            'user_id' => $user_id,
            'log' => 'create',
        ]);

        MailLog::create([
            'mail_transaction_id' => $mail_transaction->id,
            'user_id' => $user_id,
            'log' => 'send',
        ]);

        Mailer::to($target_user->email)->send(new Notification($mail));

        return redirect('/surat/masuk')->with('success', 'Berhasil menambahkan surat masuk.');
    }

    //Update Mail In
    public static function update(MailInRequest $request, $id)
    {
        // Validate Form
        $request->validated();

        //Check if Mail Exists and Mail kind is 'in'
        $mail = Mail::findOrFail($id);
        if ($mail->kind != 'in') {
            return abort(403);
        }

        //Get Last Mail Version
        $mail_version_last = $mail->mailVersions->last();

        //Check if Last Mail Transaction type isn't 'memo' or 'archive'
        $last_mail_transaction_is_memo = $mail_version_last->mailTransactions->where('type', 'memo')->isNotEmpty();
        $last_mail_transaction_is_disposition = $mail_version_last->mailTransactions->where('type', 'disposition')->isNotEmpty();

        //Redirect if Last Mail Transaction type is 'memo' or 'archive'
        if ($last_mail_transaction_is_memo || $last_mail_transaction_is_disposition) {
            return redirect('/');
        }

        // Update Mail
        $mail->update([
            'directory_code' => $request->directory_code,
            'code' => $request->code,
            'title' => $request->title,
            'origin' => $request->origin,
            'mail_folder_id' => $request->mail_folder_id,
            'mail_type_id' => $request->mail_type_id,
            'mail_reference_id' => $request->mail_reference_id,
            'mail_priority_id' => $request->mail_priority_id,
            'mail_created_at' => $request->mail_created_at,
        ]);

        // Create New Version of Mail
        $mail_version = MailVersion::create([
            'mail_id' => $mail->id,
        ]);

        // Check File, if exist Create MailFile
        if (request()->has('file')) {
            // Create & Store File (Mail File)
            $request->validate([
                'file' => 'required|file|mimes:pdf,doc,docx,jpeg,jpg,png|max:5120',
            ]);

            $file = $request->file('file');

            MailFile::create([
                'mail_version_id' => $mail_version->id,
                'original_name' => $file->getClientOriginalName(),
                'directory_name' => $file->store('documents'),
                'type' => $file->getClientOriginalExtension(),
            ]);
        }

        $mail_transaction_last = MailTransaction::select('id')->where('mail_version_id', $mail_version_last->id)->get()->last();

        $user_id = Auth::id();
        $target_user = User::select(['id', 'email'])->withPosition('Sekretaris')->first();

        // Add Corrected Log to Editor
        MailLog::create([
            'mail_transaction_id' => $mail_transaction_last->id,
            'user_id' => $user_id,
            'log' => 'corrected'
        ]);

        // === Create MailTransaction ===
        $mail_transaction = MailTransaction::create([
            'mail_version_id' => $mail_version->id,
            'user_id' => $user_id,
            'target_user_id' => $target_user->id,
            'type' => 'corrected',
        ]);

        MailLog::create([
            'mail_transaction_id' => $mail_transaction->id,
            'user_id' => $user_id,
            'log' => 'send',
        ]);

        Mailer::to($target_user->email)->send(new Notification($mail));

        return redirect('/surat/masuk')->with('success', 'Berhasil mengubah surat.');
    }

    //Delete Mail In
    public static function delete($id)
    {
        $user_id = Auth::id();

        $mail = Mail::findOrFail($id);

        if ($mail->kind != 'in') {
            return response(403);
        }

        //Get Last Mail Version
        $mail_version_last = $mail->mailVersions->last();
        $mail_transaction_last = MailTransaction::select('id')->where('mail_version_id', $mail_version_last->id)->get()->last();

        MailLog::create([
            'mail_transaction_id' => $mail_transaction_last->id,
            'user_id' => $user_id,
            'log' => 'delete',
        ]);

        $mail->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus data');
    }

    //Download Mail
    public static function download($id)
    {
        $mail = Mail::findOrFail($id);

        if ($mail->kind != 'in') {
            return response(403);
        }

        //Get Last Mail Version
        $mail_version_last = $mail->mailVersions->last();
        $mail_transaction_last = $mail_version_last->mailTransactions->last();
        $mail_file = $mail_version_last->mailFile;

        MailLog::firstOrCreate([
            'mail_transaction_id' => $mail_transaction_last->id,
            'log' => 'download',
            'user_id' => Auth::id(),
        ]);

        return Storage::download($mail->file->directory_name, $mail->file->original_name);
    }

    // Form Forward & Disposition
    public static function showProccess($id)
    {
        // Auth::login(User::find(2));
        $mail = Mail::findOrFail($id);

        // Check user is authorized for updating EmailOut
        $mail = (new MailRepository)->getMailData('in', false, $id)->first();

        $user_departments = UserDepartment::get();

        if ($mail == null) {
            return abort(403, 'Anda tidak punya akses');
        }

        $user = User::with('position')->where('id', Auth::id())->first();
        if ($user->getRole() == 'sekretaris') {
            return view('app.mails.mail-in.forward')->with(compact('mail', 'user_departments'));
        } elseif ($user->getRole() == 'kepala_dinas') {
            return view('app.mails.mail-in.disposition')->with(compact('mail', 'user_departments'));
        } else {
            return redirect('/surat/masuk');
        }
    }

    //Forward Mail In
    public static function forward(MailMemoRequest $request, $id)
    {
        // Validate Form
        $request->validated();

        //Check if Mail Exists and Mail kind is 'in'
        $mail = Mail::findOrFail($id);
        if ($mail->kind != 'in') {
            return abort(403);
        }

        //Get Last Mail Version
        $mail_version_last = $mail->mailVersions->last();

        //Check if Last Mail Transaction type is 'memo' or 'archive'
        $last_mail_transaction_is_memo = $mail_version_last->mailTransactions->where('type', 'memo')->isNotEmpty();
        $last_mail_transaction_is_disposition = $mail_version_last->mailTransactions->where('type', 'disposition')->isNotEmpty();

        //Redirect if Last Mail Transaction type is 'memo' or 'archive'
        if ($last_mail_transaction_is_memo || $last_mail_transaction_is_disposition) {
            return redirect('/');
        }


        $user_id = Auth::id();
        $target_user = User::select(['id', 'email'])->withPosition($request->target_user)->first();

        //Create Mail Transaction Memo
        $mail_transaction = MailTransaction::create([
            'mail_version_id' => $mail_version_last->id,
            'user_id' => $user_id,
            'target_user_id' => $target_user->id,
            'type' => 'memo',
        ]);

        //Store Memo
        MailMemo::create([
            'mail_transaction_id' => $mail_transaction->id,
            'memo' => $request->memo,
        ]);

        //Create Mail Log
        MailLog::create([
            'mail_transaction_id' => $mail_transaction->id,
            'user_id' => $user_id,
            'log' => 'memo',
        ]);

        MailLog::create([
            'mail_transaction_id' => $mail_transaction->id,
            'user_id' => $user_id,
            'log' => 'send',
        ]);

        Mailer::to($target_user->email)->send(new Notification($mail));

        return redirect('/surat/masuk')->with('success', 'Berhasil meneruskan surat');
    }

    public static function disposition(MailMemoRequest $request, $id)
    {
        // Validate Form
        $request->validated();

        //Check if Mail Exists and Mail kind is 'in'
        $mail = Mail::findOrFail($id);
        if ($mail->kind != 'in') {
            return response(403);
        }

        //Get Last Mail Version
        $mail_version_last = $mail->mailVersions->last();

        //Check if Last Mail Transaction type has 'memo' or 'archive'
        $last_mail_transaction_isnt_memo = $mail_version_last->mailTransactions->where('type', 'memo')->isEmpty();
        $mail_has_disposition = $mail_version_last->mailTransactions->where('type', 'disposition')->isNotEmpty();

        //Redirect if Last Mail Transaction type isn't 'memo' or mail has disposition before
        if ($last_mail_transaction_isnt_memo || $mail_has_disposition) {
            return redirect('/');
        }

        $user_id = Auth::id();

        $user = Auth::user();

        //Get Last Mail Transaction
        $mail_transaction_last = $mail_version_last->mailTransactions->last();
        // $mail_transaction_last = $mail_version_last->mailTransactions->where('target_user_id', $user->position->id)->last();

        $target_users = $request->target_user;
        foreach ($target_users as $target_department_abbreviation) {
            $user_department = UserDepartment::where('department_abbreviation', $target_department_abbreviation)->first();

            $target_user = User::withRole('kepala_bidang')->withDepartment($user_department->department)->first();

            //Create Mail Transaction Archive
            $mail_transaction = MailTransaction::create([
                'mail_version_id' => $mail_version_last->id,
                'user_id' => $user_id,
                'target_user_id' => $target_user->id,
                'type' => 'disposition',
            ]);

            //Store Memo
            MailMemo::create([
                'mail_transaction_id' => $mail_transaction->id,
                'memo' => $request->memo,
            ]);

            //Create Mail Log
            MailLog::create([
                'mail_transaction_id' => $mail_transaction->id,
                'user_id' => $user_id,
                'log' => 'disposition',
            ]);

            MailLog::create([
                'mail_transaction_id' => $mail_transaction->id,
                'user_id' => $user_id,
                'log' => 'send',
            ]);

            Mailer::to($target_user->email)->send(new Notification($mail));
        }
        $target_user = User::select(['id', 'email'])->withPosition('Kepala Bidang')->first();

        return redirect('/surat/masuk')->with('success', 'Berhasil mendisposisi surat');

        //=== Create & Download Disposition File ===
        // $secretary_memo = $mail_transaction_last->transactionMemo->memo;
        // $hod_memo = $request->memo;

        // $memo = new Collection();
        // $memo->secretary = $secretary_memo;
        // $memo->hod = $hod_memo;

        // $mail_attribute = new Collection();
        // $mail_attribute->mail = $mail;
        // $mail_attribute->memo = $memo;

        // $pdf = PDF::loadView('pdf-example', ['mail' => $mail_attribute])->setPaper('A4','potrait');
        // return $pdf->download('disposisi.pdf');
    }

    //Download Mail In Disposition
    public static function downloadDisposition($id)
    {
        $mail = Mail::findOrFail($id);
        $mail_version_last = MailVersion::select('id')->where('mail_id', $mail->id)->get()->last();

        $mail_memo_id = MailTransaction::select('id')->where([
            ['mail_version_id', $mail_version_last->id],
            ['type', 'memo'],
            ])->first();
        $mail_disposition_id = MailTransaction::select('id')->where([
            ['mail_version_id', $mail_version_last->id],
            ['type', 'disposition'],
            ])->first();

        if ($mail_memo_id == null || $mail_disposition_id == null) {
            return redirect('/');
        }

        // Create Log
        $user_id = Auth::id();
        $mail_transaction_last = $mail_version_last->mailTransactions->last();


        MailLog::firstOrCreate([
            'mail_transaction_id' => $mail_transaction_last->id,
            'user_id' => $user_id,
            'log' => 'download-disposition',
        ]);

        $mail_transaction_dispositions = MailTransaction::select('target_user_id')->where(['mail_version_id' => $mail_version_last->id, 'type' => 'disposition'])->get();

        $transaction_disposition_count = MailTransaction::select('target_user_id')->where(['mail_version_id' => $mail_version_last->id, 'type' => 'disposition'])->count();

        foreach ($mail_transaction_dispositions as $key => $mail_transaction_disposition) {
            $mail_log = MailLog::where(['mail_transaction_id' => $mail_transaction_last->id, 'user_id' => $mail_transaction_disposition->target_user_id, 'log' => 'download-disposition'])->count();
            $key = $key + $mail_log;
        }

        if ($transaction_disposition_count+1 == $key+1) {
            $mail->update(['status' => 'archive']);
        }

        //=== Create & Download File Disposisi ===
        $secretary_memo = MailMemo::select('memo')->where('mail_transaction_id', $mail_memo_id->id)->first();
        $hod_memo = MailMemo::select('memo')->where('mail_transaction_id', $mail_disposition_id->id)->first();

        $memo = new Collection();
        $memo->secretary = $secretary_memo->memo;
        $memo->hod = $hod_memo->memo;

        $mail_attribute = new Collection();
        $mail_attribute->mail = $mail;
        $mail_attribute->memo = $memo;

        $pdf = PDF::loadView('pdf-example', ['mail' => $mail_attribute])->setPaper('A4', 'potrait');
        return $pdf->download('Disposisi.pdf');

        // return response(200);
    }

    public static function archive($id)
    {
        $mail = Mail::findOrFail($id);
        $mail->status = 'archive';

        $user_id = Auth::id();
        $mail_version_last = MailVersion::select('id')->where('mail_id', $mail->id)->get()->last();
        $mail_transaction_last = $mail_version_last->mailTransactions->last();

        MailLog::firstOrCreate([
            'mail_transaction_id' => $mail_transaction_last->id,
            'user_id' => $user_id,
            'log' => 'archived',
        ]);

        if ($mail->save()) {
            return redirect()->back()->with('success', 'Berhasil mengarsipkan surat');
        }
    }
}
