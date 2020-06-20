<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PositionDetail extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
