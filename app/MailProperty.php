<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailProperty extends Model
{
    public function type()
    {
        return $this->belongsTo(MailType::class);
    }

    public function reference()
    {
        return $this->belongsTo(MailReference::class);
    }

    public function priority()
    {
        return $this->belongsTo(MailPriority::class);
    }
}
