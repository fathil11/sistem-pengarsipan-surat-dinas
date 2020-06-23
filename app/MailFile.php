<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailFile extends Model
{
    protected $guarded = [];

    public function mailVersion()
    {
        return $this->belongsTo(MailVersion::class);
    }
}
