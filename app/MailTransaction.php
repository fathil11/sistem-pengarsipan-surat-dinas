<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailTransaction extends Model
{
    use SoftDeletes;

    protected $table = 'mail_transactions';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userTarget()
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }

    public function mailVersion()
    {
        return $this->belongsToMany(MailVersion::class, 'mail_version_id');
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
