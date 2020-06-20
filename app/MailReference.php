<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailReference extends Model
{
    public function property()
    {
        return $this->hasMany(MailProperty::class);
    }
}
