<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailFolder extends Model
{
    public function mails()
    {
        return $this->hasMany(Mail::class);
    }
}
