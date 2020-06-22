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
        return $this->belongsTo(UserPosition::class);
    }

    public function department()
    {
        return $this->belongsTo(UserDepartment::class);
    }

    public function positionDetail()
    {
        return $this->belongsTo(UserPositionDetail::class);
    }

    public function outcomingMailTransactions()
    {
        return $this->belongsToMany(MailVersion::class, 'mail_transactions')->withPivot(['target_user_id'])->withTimestamps();
    }

    public function incomingMailTransaction()
    {
        return $this->belongsToMany(MailVersion::class, 'mail_transactions', 'target_user_id')->withPivot(['user_id'])->withTimestamps();
    }
}
