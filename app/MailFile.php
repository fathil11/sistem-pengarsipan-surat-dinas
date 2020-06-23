<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailFile extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function mailVersion()
    {
        return $this->belongsTo(MailVersion::class);
    }
}
