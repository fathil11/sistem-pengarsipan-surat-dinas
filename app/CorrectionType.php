<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CorrectionType extends Model
{
    public function mailCorrection()
    {
        return $this->hasMany(MailCorrection::class);
    }
}
