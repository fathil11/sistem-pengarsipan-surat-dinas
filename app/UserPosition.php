<?php

namespace App;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPosition extends Model
{
    use SoftDeletes;

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

    public static function checkRoleIsExists($role)
    {
        if (!in_array($role, self::$roles['no_extra']) &&
            !in_array($role, self::$roles['extra'])) {
            return false;
        }
        return true;
    }

    public function checkRoleHasExtra()
    {
        if (in_array($this->role, self::$roles['no_extra'])) {
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
            case 'sekretaris':
                $top_role = 'kepala_dinas';
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

    public static function getPositionId($position, $index=0)
    {
        if ($index == 1) {
            $id = self::where('position', $position)->first()->id;
        } else {
            $id = self::where('position', $position)->get()[$index]->id;
        }

        return $id;
    }
}
