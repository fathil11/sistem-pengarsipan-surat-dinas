<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailVersion extends Model
{
    public function mailTransactions()
    {
        return $this->hasMany(MailTransaction::class);
    }

    public function mail()
    {
        return $this->belongsTo(Mail::class);
    }

    public function mailFile()
    {
        return $this->hasOne(MailFile::class);
    }
}
