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
        return $this->belongsTo(MailTransaction::class, );
    }

    public function mailCorrectionType()
    {
        return $this->belongsTo(MailCorrectionType::class);
    }
}
