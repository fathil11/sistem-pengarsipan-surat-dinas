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

    public function getMailData($mail_kind)
    {
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
        })->unique('mail_id')
        ->map(function ($transaction) {
            /** @var App\User $user */
            $user = Auth::user();
            $userids = $user->withSameStakeholder()->pluck('id')->toArray();
            $status_option = [
                'income'=>[
                    'create' => ['Perlu Tanggapan', 'warning'],
                    'correction' => ['Perlu Dikoreksi', 'warning'],
                    'corrected' => ['Perlu Tanggapan', 'warning'],
                    'memo' => ['Perlu Didisposisikan', 'warning'],
                    'disposition' => ['Disposisi', 'success']
                ],'outcome'=>[
                    'create' => ['Telah Dikirimkan', 'success'],
                    'correction' => ['Menunggu Koreksi', 'primary'],
                    'corrected' => ['Telah Dikoreksi', 'success'],
                    'memo' => ['Menunggu Didisposisikan', 'primary'],
                    'disposition' => ['Telah Didisposisikan', 'success'],
            ]];

            if (in_array($transaction->user_id, $userids)) {
                $transaction->status = $status_option['outcome'][$transaction->type][0];
                $transaction->status_color = $status_option['outcome'][$transaction->type][1];
            } else {
                $transaction->status = $status_option['income'][$transaction->type][0];
                $transaction->status_color = $status_option['income'][$transaction->type][1];
            }

            $mail = $transaction->mailVersion->mail;
            $mail->status = $transaction->status;
            $mail->status_color = $transaction->status_color;
            $mail->file = $transaction->mailVersion->first()->mailFile->original_name;

            return $mail;
        });

        return $mails;
    }
}
