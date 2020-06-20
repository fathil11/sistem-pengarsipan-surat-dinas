<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailType extends Model
{
    public function property()
    {
        return $this->hasMany(MailProperty::class);
    }
}
