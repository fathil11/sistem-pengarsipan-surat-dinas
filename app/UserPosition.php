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
        $role = self::find($position_id);

        if ($role == null) {
            return false;
        }
        return true;
    }

    public static function checkRoleIsExists($role)
    {
        if (!in_array($role, self::$roles['no_extra']) &&
            !in_array($role, self::$roles['extra'])) {
            return false;
        }
        return true;
    }

    public static function checkPositionIdHasExtra($position_id)
    {
        $role = self::find($position_id)->role;
        if (in_array($role, self::$roles['no_extra'])) {
            return false;
        }
        return true;
    }

    public static function getTopRole($role)
    {
        if (!self::checkRoleIsExists($role)) {
            return null;
        }

        // Search role index in order
        $order = array_merge(self::$roles['no_extra'], self::$roles['extra']);
        $role_position = array_search($role, $order);

        // Assigning itself role when the role is Admin or Kepala Dinas
        if ($role_position == 0 || $role_position == 1) {
            $top_role = $role;
        } else {
            $top_role = $order[$role_position-1];
        }

        return $top_role;
    }
}
