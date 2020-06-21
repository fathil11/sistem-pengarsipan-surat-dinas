<?php

namespace App\Services\User;

use App\User;

class UserInfo
{
    public function getRole($id)
    {
        $user = User::find($id);
        $user_position = $user->position();
        $role = $user_position->role()->access;
        return $role;
    }
}
