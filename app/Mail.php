<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    public function mailVersions()
    {
        return $this->hasMany(MailVersion::class);
    }

    public function folder()
    {
        return $this->belongsTo(MailFolder::class);
    }

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
