<?php

namespace App\Repository;

use App\Mail;
use App\User;
use App\UserPosition;
use App\MailTransaction;
use Illuminate\Database\Eloquent\Builder;

class MailRepository
{
    public function getMailWithSameStakeHolder($user_id, $mail_kind)
    {
        $mails = Mail::whereHas('mailVersions', function (Builder $query) use ($user_id, $mail_kind) {
            return $query->whereHas('mailTransactions', function (Builder $query) use ($user_id, $mail_kind) {
                return $query->withSameStakeHolder($user_id, $mail_kind);
            });
        })->get()
        ->map(function ($mail) {
            $mail->type = $mail->type->type;


            $mail->date_in = '21 Okt';
            return $mail;
        });

        return $mails;
    }
}
