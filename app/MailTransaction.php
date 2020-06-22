<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class MailTransaction extends Model
{
    public function user()
    {
        return $this->belongsToMany(User::class)->withPivot(['target_user_id'])->withTimestamps();
    }

    public function userTarget()
    {
        return $this->belongsToMany(User::class, 'target_user_id')->withPivot(['user_id'])->withTimestamps();
    }

    public function mailVersion()
    {
        return $this->belongsToMany(MailVersion::class);
    }

    public function transactionLog()
    {
        return $this->hasMany(MailLog::class);
    }

    public function transactionCorrection()
    {
        return $this->hasOne(MailCorrection::class);
    }

    public function transactionMemo()
    {
        return $this->hasOne(MailMemo::class);
    }
}
