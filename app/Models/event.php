<?php

namespace App\Models;

use App\Models\Traits\HasElastic;
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
    use HasElastic;

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
