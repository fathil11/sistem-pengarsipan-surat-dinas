<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailTransaction extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function userTarget()
    {
        return $this->belongsTo('App\User', 'target_user_id');
    }

    public function transactionLog()
    {
        return $this->hasMany('App\MailLog');
    }

    public function transactionCorrection()
    {
        return $this->hasMany('App\MailCorrection');
    }

    public function transactionMemo()
    {
        return $this->hasMany('App\MailMemo');
    }

    public function mailVersion()
    {
        return $this->belongsTo('App\MailVersion');
    }
}
