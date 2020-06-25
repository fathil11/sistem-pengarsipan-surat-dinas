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
        });

        return $mails;
    }
}
