<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function position()
    {
        return $this->belongsTo(UserPosition::class, 'user_position_id');
    }

    public function department()
    {
        return $this->belongsTo(UserDepartment::class, 'user_department_id');
    }

    public function positionDetail()
    {
        return $this->belongsTo(UserPositionDetail::class, 'user_position_detail_id');
    }

    public function outcomingMailTransactions()
    {
        return $this->belongsToMany(MailVersion::class, 'mail_transactions')->withPivot(['target_user_id', 'type'])->withTimestamps();
    }

    public function incomingMailTransaction()
    {
        return $this->belongsToMany(MailVersion::class, 'mail_transactions', 'target_user_id')->withPivot(['user_id', 'type'])->withTimestamps();
    }

    public function getRole()
    {
        return $this->position->role;
    }

    public function getDepartment()
    {
        return $this->department->department;
    }

    public function scopeWithDepartment(Builder $query, $department)
    {
        return $query->whereHas('department', function (Builder $query) use ($department) {
            return $query->where('department', $department);
        });
    }

    public function scopeWithRole(Builder $query, $role)
    {
        return $query->whereHas('position', function (Builder $query) use ($role) {
            return $query->where('role', $role);
        });
    }
}
