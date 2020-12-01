<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $casts = [
        'data' => 'json',
    ];

    protected $dateFormat = 'Y-m-d\TH:i:s.u';

    protected $primaryKey = 'uuid';

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}
