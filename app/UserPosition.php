<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPosition extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
