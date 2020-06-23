<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailVersion extends Model
{
    protected $guarded = [];

    public function mailTransactions()
    {
        return $this->hasMany(MailTransaction::class);
    }

    public function mail()
    {
        return $this->belongsTo(Mail::class, 'mail_id');
    }

    public function mailFile()
    {
        return $this->hasOne(MailFile::class);
    }
}
