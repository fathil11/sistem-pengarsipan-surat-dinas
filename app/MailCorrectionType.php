<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailCorrectionType extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function mailCorrection()
    {
        return $this->hasMany(MailCorrection::class);
    }
}
