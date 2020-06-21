<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->hasOne(Position::class);
    }
}
