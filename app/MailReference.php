<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailReference extends Model
{
    public function mails()
    {
        return $this->hasMany(Mail::class);
    }
}
