<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailPriority extends Model
{
    public function mails()
    {
        return $this->hasMany(Mail::class);
    }
}
