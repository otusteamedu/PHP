<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Event
 * @package App\Models
 * @property int id
 * @property stirng name
 * @property array conditions
 * @property int priority
 */
class Event extends Model
{
    use HasFactory;

    protected $casts = [
        'conditions' => 'array',
    ];

    public $fillable = [
        'id',
        'name',
        'conditions',
        'priority',
    ];
}
