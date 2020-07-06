<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailType extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function mails()
    {
        return $this->hasMany(Mail::class);
    }
}
