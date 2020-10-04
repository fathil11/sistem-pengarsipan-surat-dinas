<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Repository\MailRepository;

use App\User;
use App\UserPosition;
use App\UserDepartment;

use App\Mail;
use App\MailVersion;
use App\MailFile;
use App\MailTransaction;
use App\MailLog;
use App\MailMemo;

use Carbon\Carbon;

use Illuminate\Support\Str;

use Yajra\DataTables\Facades\DataTables as DataTables;

use PDF;

class TestingController extends Controller
{
    public function showMailIn($id)
    {
        // Auth::login(User::find(6));
        $mail = Mail::findOrFail($id);

        // Check user is authorized for updating EmailOut
        $mail = (new MailRepository)->getMailData('in', false, $id)->first();

        if ($mail == null) {
            return abort(403, 'Anda tidak punya akses');
        }
        return view('app.mails.mail-view', compact('mail'));
    }


    //=== Arsip Surat ===
    public function showMailArchiveFolder()
    {
        return view('app.mails.all-mail.archive-mail-folder-list');
    }

    public function showMailArchiveFolderYear()
    {
        $mails = Mail::select(DB::raw('YEAR(mail_created_at) as year'))->where('status', 'archive')->orderBy('mail_created_at')->distinct()->get();
        $years = $mails->pluck('year');
        return view('app.mails.all-mail.archive-mail-year-list')->with(compact('years'));
    }


    //Json method
    public function jsonMailArchiveAll()
    {
        $mails = Mail::with('type', 'reference', 'priority')->where('status', 'archive')->select('mails.*');
        return DataTables::of($mails)
                            ->addColumn('folder', function(Mail $mails){
                                return $mails->folder->folder;
                            })
                            ->addColumn('type', function(Mail $mails){
                                return $mails->type->type;
                            })
                            ->addColumn('reference', function(Mail $mails){
                                return $mails->reference->type;
                            })
                            ->addColumn('priority', function(Mail $mails){
                                return $mails->priority->type;
                            })
                            ->addColumn('download', 'layouts.mail-download')
                            ->addColumn('full-title', function(Mail $mails){
                                $fullTitle = '<div class="text-wrap">
                                <h6>' . Str::limit($mails->title, 40) . '</h6>
                            </div>
                            <div>' . $mails->code . '</div>
                            <label class="badge mt-2 text-white"
                                style="background: ' . $mails->type->color . '">' . Str::upper($mails->type->type) . '</label>
                            <label class="badge mt-2 text-white"
                                style="background: ' . $mails->reference->color . '">' . Str::upper($mails->reference->type) . '</label>
                            <label class="badge mt-2 text-white"
                                style="background: ' . $mails->priority->color.'">'.Str::upper($mails->priority->type) . '</label>';

                                return $fullTitle;
                            })
                            ->rawColumns(['download', 'full-title'])
                            ->make(true);
    }

    public function jsonMailArchiveMailIn()
    {
        $mails = Mail::with('type', 'reference', 'priority')->where(['status' => 'archive', 'kind' => 'in'])->select('mails.*');
        return DataTables::of($mails)
                            ->addColumn('folder', function(Mail $mails){
                                return $mails->folder->folder;
                            })
                            ->addColumn('type', function(Mail $mails){
                                return $mails->type->type;
                            })
                            ->addColumn('reference', function(Mail $mails){
                                return $mails->reference->type;
                            })
                            ->addColumn('priority', function(Mail $mails){
                                return $mails->priority->type;
                            })
                            ->addColumn('download', 'layouts.mail-download')
                            ->addColumn('full-title', function(Mail $mails){
                                $fullTitle = '<div class="text-wrap">
                                <h6>' . Str::limit($mails->title, 40) . '</h6>
                            </div>
                            <div>' . $mails->code . '</div>
                            <label class="badge mt-2 text-white"
                                style="background: ' . $mails->type->color . '">' . Str::upper($mails->type->type) . '</label>
                            <label class="badge mt-2 text-white"
                                style="background: ' . $mails->reference->color . '">' . Str::upper($mails->reference->type) . '</label>
                            <label class="badge mt-2 text-white"
                                style="background: ' . $mails->priority->color.'">'.Str::upper($mails->priority->type) . '</label>';

                                return $fullTitle;
                            })
                            ->rawColumns(['download', 'full-title'])
                            ->make(true);
    }

    public function jsonMailArchiveMailOut()
    {
        $mails = Mail::with('type', 'reference', 'priority')->where(['status' => 'archive', 'kind' => 'out'])->select('mails.*');
        return DataTables::of($mails)
                            ->addColumn('folder', function(Mail $mails){
                                return $mails->folder->folder;
                            })
                            ->addColumn('type', function(Mail $mails){
                                return $mails->type->type;
                            })
                            ->addColumn('reference', function(Mail $mails){
                                return $mails->reference->type;
                            })
                            ->addColumn('priority', function(Mail $mails){
                                return $mails->priority->type;
                            })
                            ->addColumn('download', 'layouts.mail-download')
                            ->addColumn('full-title', function(Mail $mails){
                                $fullTitle = '<div class="text-wrap">
                                <h6>' . Str::limit($mails->title, 40) . '</h6>
                            </div>
                            <div>' . $mails->code . '</div>
                            <label class="badge mt-2 text-white"
                                style="background: ' . $mails->type->color . '">' . Str::upper($mails->type->type) . '</label>
                            <label class="badge mt-2 text-white"
                                style="background: ' . $mails->reference->color . '">' . Str::upper($mails->reference->type) . '</label>
                            <label class="badge mt-2 text-white"
                                style="background: ' . $mails->priority->color.'">'.Str::upper($mails->priority->type) . '</label>';

                                return $fullTitle;
                            })
                            ->rawColumns(['download', 'full-title'])
                            ->make(true);
    }

    public function jsonMailArchiveYear($year)
    {
        $mails = Mail::with('type', 'reference', 'priority')->whereYear('mail_created_at', $year)->where(['status' => 'archive'])->select('mails.*');
        return DataTables::of($mails)
                            ->addColumn('folder', function(Mail $mails){
                                return $mails->folder->folder;
                            })
                            ->addColumn('type', function(Mail $mails){
                                return $mails->type->type;
                            })
                            ->addColumn('reference', function(Mail $mails){
                                return $mails->reference->type;
                            })
                            ->addColumn('priority', function(Mail $mails){
                                return $mails->priority->type;
                            })
                            ->addColumn('download', 'layouts.mail-download')
                            ->addColumn('full-title', function(Mail $mails){
                                $fullTitle = '<div class="text-wrap">
                                <h6>' . Str::limit($mails->title, 40) . '</h6>
                            </div>
                            <div>' . $mails->code . '</div>
                            <label class="badge mt-2 text-white"
                                style="background: ' . $mails->type->color . '">' . Str::upper($mails->type->type) . '</label>
                            <label class="badge mt-2 text-white"
                                style="background: ' . $mails->reference->color . '">' . Str::upper($mails->reference->type) . '</label>
                            <label class="badge mt-2 text-white"
                                style="background: ' . $mails->priority->color.'">'.Str::upper($mails->priority->type) . '</label>';

                                return $fullTitle;
                            })
                            ->rawColumns(['download', 'full-title'])
                            ->make(true);
    }

    public function showMailArchiveAll()
    {
        // $mails = Mail::with('type', 'reference', 'priority')->where('status', 'archive')->orderBy('mail_created_at')->get();
        // return view('app.mails.all-mail.archive-mail-list')->with(compact('mails'));
        return view('app.mails.all-mail.archive-mail-list');
    }

    public function showMailArchiveMailIn()
    {
        // $mails = Mail::with('type', 'reference', 'priority')->where(['status' => 'archive', 'kind' => 'in'])->orderBy('mail_created_at')->get();
        // return view('app.mails.all-mail.archive-mail-list')->with(compact('mails'));
        return view('app.mails.all-mail.archive-mail-list');
    }

    public function showMailArchiveMailOut()
    {
        // $mails = Mail::with('type', 'reference', 'priority')->where(['status' => 'archive', 'kind' => 'out'])->orderBy('mail_created_at')->get();
        // return view('app.mails.all-mail.archive-mail-list')->with(compact('mails'));
        return view('app.mails.all-mail.archive-mail-list');
    }

    public function showMailArchiveYear($year)
    {
        // $mails = Mail::with('type', 'reference', 'priority')->whereYear('mail_created_at', $year)->where('status', 'archive')->orderBy('mail_created_at')->get();
        // return view('app.mails.all-mail.archive-mail-list')->with(compact('mails'));
        return view('app.mails.all-mail.archive-mail-list');
    }


    public function mailInList()
    {
        $mails = Mail::with('type', 'reference', 'priority', 'mailVersions', 'mailVersions.mailTransactions')->where('kind', 'in')->whereNull('status')->orderBy('mail_created_at')->get();

        return view('app.mails.all-mail.all-mail-list')->with(compact('mails'));
    }

    public function mailOutList()
    {
        $mails = Mail::with('type', 'reference', 'priority')->where('kind', 'out')->whereNull('status')->orderBy('mail_created_at')->get();
        return view('app.mails.all-mail.all-mail-list')->with(compact('mails'));
    }

    public function tes()
    {
        return response(200);
    }
}
