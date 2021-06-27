<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    const NOT_PROCCESSD = 1;

    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    protected $attributes = [
        'status' => self::NOT_PROCCESSD,
    ];
}
