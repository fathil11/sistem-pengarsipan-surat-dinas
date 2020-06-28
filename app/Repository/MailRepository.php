<?php

namespace App\Repository;

use App\MailTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class MailRepository
{
    public function withSameStakeholder($mail_kind)
    {
        /** @var App\User $user */
        $user = Auth::user();
        $userids = $user->withSameStakeholder()->pluck('id')->toArray();

        $transactions = MailTransaction::where(function ($query) use ($userids) {
            $query->whereIn('user_id', $userids)
            ->orWhereIn('target_user_id', $userids);
        })
        ->whereHas('mailVersion', function (Builder $query) use ($mail_kind) {
            $query->whereHas('mail', function (Builder $query) use ($mail_kind) {
                return $query->where('kind', $mail_kind);
            });
        });

        return $transactions;
    }

    public function getMailData($mail_kind, $only_mail_id=false, $mail_id=null)
    {
        if ($only_mail_id) {
            $mails = $this->withSameStakeholder($mail_kind)
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

        $mails = $this->withSameStakeholder($mail_kind)
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
                    'status'=>'Perlu Tanggapan',
                    'color' => 'danger',
                    'in' => ['Log'],
                    'out' => ['Log']],
                'correction'=>[
                    'status'=>'Perlu Dikoreksi',
                    'color' => 'danger',
                    'in' => ['Log', 'Correction'],
                    'out' => ['Log', 'Correction']],
                'corrected'=>[
                    'status'=>'Perlu Tanggapan',
                    'color' => 'danger',
                    'in' => ['Log', 'Correction'],
                    'out' => ['Log', 'Correction']],
                'memo'=>[
                    'status'=>'Perlu Didisposisikan',
                    'color' => 'danger',
                    'in' => ['Log', 'Memo'],
                    'out' => []],
                'disposition'=>[
                    'status'=>'Disposisi',
                    'color' => 'success',
                    'in'=> ['Memo'], 'out' => []],
                'forward'=>[
                    'status'=>'Perlu Tanggapan',
                    'color' => 'danger',
                    'in'=> [],
                    'out' => ['Log']],
            ],
            'outcome'=>[
                'create'=>[
                    'status' => 'Menunggu Tanggapan',
                    'color' => 'success',
                    'in' => ['Log'],
                    'out' => ['Log']],
                'correction'=>[
                    'status' => 'Menunggu Koreksi',
                    'color' => 'secondary',
                    'in' => ['Log',
                    'Correction'], 'out' => ['Log', 'Correction']],
                'corrected'=>[
                    'status' => 'Telah Dikoreksi',
                    'color' => 'success',
                    'in' => ['Log',
                    'Correction'], 'out' => ['Log', 'Correction']],
                'memo'=>[
                    'status' => 'Menunggu Didisposisikan',
                    'color' => 'primary',
                    'in' => ['Log',
                    'Memo'], 'out' => ['Log', 'Memo']],
                'disposition'=>[
                    'status' => 'Telah Didisposisikan',
                    'color' => 'success',
                    'in' => ['Memo'],
                    'out' => []],
                'forward'=>[
                    'status' => 'Menunggu Tanggapan',
                    'color' => 'primary',
                    'in'=> [], 'out' =>
                    ['Log']],
            ]];

            if (in_array($transaction->user_id, $userids)) {
                $transaction->status = $status_option['outcome'][$transaction->type];
                $transaction->transaction = 'outcome';
            } else {
                $transaction->status = $status_option['income'][$transaction->type];
                $transaction->transaction = 'income';
            }

            $mail = $transaction->mailVersion->mail;

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
            $mail->file = $transaction->mailVersion->first()->mailFile;
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
