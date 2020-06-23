<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPosition extends Model
{
    protected $guarded = [];

    private static $roles = [
    'no_extra' =>
        ['admin',
        'kepala_dinas',
        'sekretaris',
        'kepala_tu'],
    'extra' =>
        ['kepala_bidang',
        'kepala_seksie']
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public static function checkPositionIdIsExists($position_id)
    {
        $role = UserPosition::find($position_id);

        if ($role == null) {
            return false;
        }
        return true;
    }

    public static function checkRoleIsExists($role)
    {
        if (!in_array($role, UserPosition::$roles['no_extra']) &&
            !in_array($role, UserPosition::$roles['extra'])) {
            return false;
        }
        return true;
    }

    public static function checkPositionIdHasExtra($position_id)
    {
        $role = UserPosition::find($position_id)->role;
        if (in_array($role, UserPosition::$roles['no_extra'])) {
            return false;
        }
        return true;
    }
}
