<?php

namespace App\Services\User;

use App\User;

class UserIncomingMail
{
    public function getIncomingMails($id)
    {
        $user = User::find($id);
        $mail_transactions = $user->mailTransactions();
        return $mail_transactions;
    }
}
