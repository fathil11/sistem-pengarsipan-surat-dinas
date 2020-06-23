<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mail extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function mailVersions()
    {
        return $this->hasMany(MailVersion::class);
    }

    public function folder()
    {
        return $this->belongsTo(MailFolder::class, 'mail_folder_id');
    }

    public function type()
    {
        return $this->belongsTo(MailType::class, 'mail_type_id');
    }

    public function reference()
    {
        return $this->belongsTo(MailReference::class, 'mail_reference_id');
    }

    public function priority()
    {
        return $this->belongsTo(MailPriority::class, 'mail_priority_id');
    }
}
