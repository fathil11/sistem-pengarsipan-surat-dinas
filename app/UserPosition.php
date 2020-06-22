<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPosition extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public static function getUsersInRole(String $role)
    {
        $user_position = UserPosition::where('role', $role)->get();

        return User::where('user_position_id', $user_position->id)->get();
    }
}
