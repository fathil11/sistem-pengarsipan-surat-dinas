<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailLog extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function mailTransaction()
    {
        return $this->belongsTo(MailTransaction::class);
    }
}
