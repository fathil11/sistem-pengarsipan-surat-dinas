<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailLog extends Model
{
    public function mailTransaction()
    {
        return $this->belongsTo(MailTransaction::class);
    }
}
