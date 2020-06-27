<?php

namespace App\Repository;

use App\MailTransaction;
use Illuminate\Support\Facades\Auth;

class MailRepository
{
    public function withSameStakeholder($mail_kind, $incoming_mail=true)
    {
        /** @var App\User $user */
        $user = Auth::user();
        $userids = $user->withSameStakeholder()->pluck('id')->toArray();

        if ($incoming_mail) {
            $user_id_column = 'target_user_id';
        } else {
            $user_id_column = 'user_id';
        }

        $transactions = MailTransaction::whereIn($user_id_column, $userids)
        ->whereHas('mailVersion', function ($query) use ($mail_kind) {
            return $query->whereHas('mail', function ($query) use ($mail_kind) {
                return $query->where('kind', $mail_kind);
            });
        });

        return $transactions;
    }

    public function getMailData($mail_kind, $incoming_mail=true)
    {
        $mails = $this->withSameStakeholder($mail_kind, $incoming_mail)->get()
        ->map(function ($transaction) {
            $mail = $transaction->mailVersion->mail;

            // Assign Status
            $mail->status = $transaction->type;
            switch ($mail->status) {
                case 'create':
                    $mail->status = 'Telah dikirim';
                    break;
                case 'correction':
                    $mail->status = 'Perlu Dikoreksi';
                    break;
                case 'corrected':
                    $mail->status = 'Telah diperbaiki';
                    break;
            }
            $mail->type = $mail->type->type;
            $mail->file = $transaction->mailVersion->mailFile->directory_name;
            return $mail;
        });

        return $mails;
    }
}
