<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailFile extends Model
{
    public function mailVersion()
    {
        return $this->belongsTo(MailVersion::class);
    }
}
