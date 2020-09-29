<?php

namespace App\Repository;

use App\MailTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class MailRepository
{
    public function withSameStakeholder($mail_kind, $all)
    {
        /** @var App\User $user */
        $user = Auth::user();
        $userids = $user->withSameStakeholder()->pluck('id')->toArray();

        // Get mail transaction with user or target user role
        $transactions = MailTransaction::where(function ($query) use ($userids) {
            $query->whereIn('user_id', $userids)
            ->orWhereIn('target_user_id', $userids);
        })
        ->whereHas('mailVersion', function (Builder $query) use ($mail_kind, $all) {
            $query->select('mail_id')->whereHas('mail', function (Builder $query) use ($mail_kind, $all) {
                if ($all) {
                    return $query->select('kind')->where('kind', $mail_kind);
                }
                return $query->select('kind')->whereNull('status')->where('kind', $mail_kind);
            });
        });

        return $transactions;
    }

    public function getMailData($mail_kind, $only_mail_id=false, $mail_id=null, $all=false)
    {
        if ($only_mail_id) {
            $mails = $this->withSameStakeholder($mail_kind, $all)
            ->with([
            'mailVersion',
            'mailVersion.mail'
            ])
            ->orderBy('id', 'DESC')->get()->unique('mail_version_id')
            ->map(function ($transaction) {
                $transaction->mail_id = $transaction->mailVersion->mail_id;
                return $transaction;
            })->pluck('mail_id');
            return $mails;
        }

        $mails = $this->withSameStakeholder($mail_kind, $all)
        ->with([
        'mailVersion',
        'mailVersion.mail',
        'mailVersion.mail.reference',
        'mailVersion.mail.priority',
        'mailVersion.mail.type',
        'mailVersion.mailFile'
        ])
        ->orderBy('id', 'DESC')->get()->unique('mail_version_id')
        ->map(function ($transaction) {
            $transaction->mail_id = $transaction->mailVersion->mail_id;
            return $transaction;
        })->unique('mail_id');

        if ($mail_id != null) {
            $mails = $mails->where('mail_id', $mail_id);
        }

        $mails = $mails->map(function ($transaction) use ($mail_id, $mail_kind) {
            /** @var App\User $user */
            $user = Auth::user();
            $userids = $user->withSameStakeholder()->pluck('id')->toArray();

            $status_option = [
            'income'=>[
                'create'=>[
                    'type' => 'create',
                    'status'=>'Perlu Tanggapan',
                    'color' => 'danger',
                    'action' => 'buat-koreksi',
                    'in' => ['Log'],
                    'out' => ['Log']],
                'correction'=>[
                    'type' => 'correction',
                    'status'=>'Perlu Dikoreksi',
                    'color' => 'danger',
                    'action' => 'koreksi',
                    'in' => ['Log', 'Correction'],
                    'out' => ['Log', 'Correction']],
                'corrected'=>[
                    'type' => 'corrected',
                    'status'=>'Perlu Tanggapan',
                    'color' => 'danger',
                    'action' => 'buat-koreksi',
                    'in' => ['Log', 'Correction'],
                    'out' => ['Log', 'Correction']],
                'memo'=>[
                    'type' => 'memo',
                    'status'=>'Perlu Didisposisikan',
                    'color' => 'danger',
                    'action' => 'disposisi',
                    'in' => ['Log', 'Memo'],
                    'out' => []],
                'disposition'=>[
                    'type' => 'disposition',
                    'status'=>'Disposisi',
                    'color' => 'success',
                    'action' => '',
                    'in'=> ['Memo'],
                    'out' => []],
                'forward'=>[
                    'type' => 'forward',
                    'status'=>'Perlu Tanggapan',
                    'color' => 'danger',
                    'action' => '',
                    'in'=> [],
                    'out' => ['Log']],
            ],
            'outcome'=>[
                'create'=>[
                    'type' => 'create',
                    'action' => '',
                    'status' => 'Menunggu Tanggapan',
                    'color' => 'success',
                    'in' => ['Log'],
                    'out' => ['Log']],
                'correction'=>[
                    'type' => 'correction',
                    'action' => '',
                    'status' => 'Menunggu Koreksi',
                    'color' => 'secondary',
                    'in' => ['Log', 'Correction'],
                    'out' => ['Log', 'Correction']],
                'corrected'=>[
                    'type' => 'corrected',
                    'action' => '',
                    'status' => 'Telah Dikoreksi',
                    'color' => 'success',
                    'in' => ['Log', 'Correction'],
                    'out' => ['Log', 'Correction']],
                'memo'=>[
                    'type' => 'memo',
                    'action' => '',
                    'status' => 'Menunggu Didisposisikan',
                    'color' => 'primary',
                    'in' => ['Log', 'Memo'],
                    'out' => ['Log', 'Memo']],
                'disposition'=>[
                    'type' => 'disposition',
                    'action' => '',
                    'status' => 'Telah Didisposisikan',
                    'color' => 'success',
                    'in' => ['Memo'],
                    'out' => []],
                'forward'=>[
                    'type' => 'forward',
                    'action' => '',
                    'status' => 'Menunggu Tanggapan',
                    'color' => 'primary',
                    'in'=> [],
                    'out' =>['Log']],
            ]];

            if (in_array($transaction->user_id, $userids)) {
                $transaction->status = $status_option['outcome'][$transaction->type];
                $transaction->transaction = 'outcome';
            } else {
                $transaction->status = $status_option['income'][$transaction->type];
                $transaction->transaction = 'income';
            }

            $mail = $transaction->mailVersion->mail;
            $mail->transaction_time = $transaction->created_at;
            $mail->transaction_id = $transaction->id;

            if ($mail_id != null) {
                foreach ($transaction->status[$mail_kind] as $item) {
                    switch ($item) {
                        case 'Log':
                            $mail->logs = $transaction->transactionLogs;
                            break;
                        case 'Correction':
                            $mail->correction = $transaction->transactionCorrection;
                            break;
                        case 'Memo':
                            $mail->memo = $transaction->transactionMemo;
                            break;
                    }
                }
            }

            $mail->status = $transaction->status;
            $mail->file = $transaction->mailVersion->mailFile;
            $mail->transaction = $transaction->transaction;

            return $mail;
        });

        return $mails;
    }

    public function checkMailAccess($mail_id, $mail_kind='in')
    {
        $mails = $this->getMailData($mail_kind, true);
        foreach ($mails as $mail) {
            if ($mail_id == $mail) {
                return true;
            }
        }
        return false;
    }
}
