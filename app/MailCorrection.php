<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailCorrection extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function mailTransaction()
    {
        return $this->belongsTo(MailTransaction::class, 'mail_transaction_id');
    }

    public function mailCorrectionType()
    {
        return $this->belongsTo(MailCorrectionType::class);
    }
}
