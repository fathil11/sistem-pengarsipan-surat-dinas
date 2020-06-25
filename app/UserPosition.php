<?php

namespace App;

use Illuminate\Database\Query\Builder;
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

    public static function checkRoleHasExtra($role)
    {
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

        switch ($role) {
            case 'admin': case 'kepala_dinas':
                $top_role = 'kepala_tu';
                break;
            case 'kepala_bidang':
                $top_role = 'sekretaris';
                break;
            case 'kepala_seksie':
                $top_role = 'kepala_bidang';
                break;
            default:
                $top_role = null;
                break;
        }

        return $top_role;
    }
}
