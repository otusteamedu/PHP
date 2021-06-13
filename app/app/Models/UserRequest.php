<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRequest extends Model
{
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public const CREATED = 'created';
    public const IN_PROGRESS = 'in_progress';
    public const COMPLETED = 'complete';

    public const TYPES_ALLOWED = [
        self::FILM_REPORT,
    ];

    public const FILM_REPORT = 'film_report';
}
