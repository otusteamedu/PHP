<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    const NOT_PROCCESED = 1;

    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    protected $table='tasks';

    protected $attributes = [
        'status' => self::NOT_PROCCESED,
    ];
}
