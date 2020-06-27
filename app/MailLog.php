<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailLog extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function mailTransaction()
    {
        return $this->belongsTo(MailTransaction::class);
    }

    public function getLogAttribute($value)
    {
        switch ($value) {
            case 'create':
                $log = 'Dibuat';
                break;
            case 'send':
                $log = 'Dikirim';
                break;
            case 'corrected':
                $log = 'Dikoreksi';
                break;
            case 'delete':
                $log = 'Dihapus';
                break;
            case 'read':
                $log = 'Dilihat';
                break;
            case 'download':
                $log = 'Diunduh';
                break;
            default:
                # code...
                break;
        }

        return $log;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
