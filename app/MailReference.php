<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailReference extends Model
{
    protected $guarded = [];

    public function mails()
    {
        return $this->hasMany(Mail::class);
    }
}
