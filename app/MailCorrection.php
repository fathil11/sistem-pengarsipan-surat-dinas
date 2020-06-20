<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailCorrection extends Model
{
    public function mailTransaction()
    {
        return $this->belongsTo(MailTransaction::class);
    }

    public function correctionType()
    {
        return $this->belongsTo(CorrectionType::class);
    }
}
