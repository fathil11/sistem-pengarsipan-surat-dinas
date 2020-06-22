<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailCorrectionType extends Model
{
    public function mailCorrection()
    {
        return $this->hasMany(MailCorrection::class);
    }
}
