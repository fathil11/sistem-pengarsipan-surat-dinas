<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailType extends Model
{
    protected $guarded = [];

    public function mails()
    {
        return $this->hasMany(Mail::class);
    }
}
