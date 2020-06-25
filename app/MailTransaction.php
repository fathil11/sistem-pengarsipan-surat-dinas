<?php

namespace App;

use App\Repository\MailRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailTransaction extends Model
{
    use SoftDeletes;

    protected $table = 'mail_transactions';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userTarget()
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }

    public function mailVersion()
    {
        return $this->belongsTo(MailVersion::class, 'mail_version_id');
    }

    public function transactionLogs()
    {
        return $this->hasMany(MailLog::class);
    }

    public function transactionCorrection()
    {
        return $this->hasOne(MailCorrection::class);
    }

    public function transactionMemo()
    {
        return $this->hasOne(MailMemo::class);
    }

    public function scopeWithSameStakeholder(Builder $query, $user_id, $mail_kind, $incoming=true)
    {
        $user = User::find($user_id);

        if ($user == null) {
            return abort(503, 'user_id not found');
        }

        if ($mail_kind != 'in' && $mail_kind != 'out') {
            return abort(503, 'mail_kind is not valid. It must be \'in\' or \'out\'');
        }

        if ($incoming) {
            $user_as = 'userTarget';
        } else {
            $user_as = 'user';
        }

        $role = $user->getRole();
        if (UserPosition::checkRoleHasExtra($role)) {
            $department = $user->getDepartment();
            $transactions = $query->whereHas('mailVersion', function (Builder $query) use ($mail_kind) {
                return $query->whereHas('mail', function (Builder $query) use ($mail_kind) {
                    return $query->where('kind', $mail_kind);
                });
            })->whereHas($user_as, function (Builder $query) use ($role, $department) {
                return $query->withRole($role)->withDepartment($department);
            });
        } else {
            $transactions = $query->whereHas('mailVersion', function (Builder $query) use ($mail_kind) {
                return $query->whereHas('mail', function (Builder $query) use ($mail_kind) {
                    return $query->where('kind', $mail_kind);
                });
            })->whereHas($user_as, function (Builder $query) use ($role) {
                return $query->withRole($role);
            });
        }

        return $transactions;
    }
}
