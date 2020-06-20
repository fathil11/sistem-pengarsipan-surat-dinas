<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    public function mailVersions()
    {
        return $this->hasMany(MailVersion::class);
    }

    public function mailProperty()
    {
        return $this->hasMany(MailProperty::class);
    }
}
