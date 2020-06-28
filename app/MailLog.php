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
                $log = 'Diteruskan';
                break;
            case 'disposition':
                $log = 'Didisposisi';
                break;
            case 'memo':
                $log = 'Diberi note';
                break;
            case 'corrected': case 'correction':
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
            case 'archived':
                $log = 'Diarsipkan';
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
