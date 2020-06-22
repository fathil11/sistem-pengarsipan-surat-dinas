<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

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

    public static function getUsersInRole(String $role)
    {
        return UserPosition::where('role', $role)->get();
    }
}
