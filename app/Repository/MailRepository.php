<?php

namespace App\Repository;

use App\User;
use App\UserPosition;
use App\MailTransaction;
use Illuminate\Database\Eloquent\Builder;

class MailRepository
{
    public function getWithSameStakeholder($user_id, $mail_kind)
    {
        $user = User::find($user_id);

        if ($user == null) {
            return abort(503, 'user_id not found');
        }

        if ($mail_kind != 'in' && $mail_kind != 'out') {
            return abort(503, 'mail_kind is not valid. It must be \'in\' or \'out\'');
        }

        $role = $user->getRole();

        if (UserPosition::checkRoleHasExtra($role)) {
            $department = $user->getDepartment();

            $transactions = MailTransaction::whereHas('mailVersion', function (Builder $query) use ($mail_kind) {
                return $query->whereHas('mail', function (Builder $query) use ($mail_kind) {
                    return $query->where('kind', $mail_kind);
                });
            })->whereHas('userTarget', function (Builder $query) use ($role, $department) {
                return $query->withRole($role)->withDepartment($department);
            });
        } else {
            $transactions = MailTransaction::whereHas('mailVersion', function (Builder $query) use ($mail_kind) {
                return $query->whereHas('mail', function (Builder $query) use ($mail_kind) {
                    return $query->where('kind', $mail_kind);
                });
            })->whereHas('userTarget', function (Builder $query) use ($role) {
                return $query->withRole($role);
            });
        }

        return $transactions->get();
    }
}
