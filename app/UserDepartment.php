<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDepartment extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public static function getDepartmentId($department_abbreviation)
    {
        return self::where('department_abbreviation', $department_abbreviation)->first()->id;
    }
}
