<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailMemo extends Model
{
    public function mailTransaction()
    {
        return $this->belongsTo(MailTransaction::class);
    }
}
