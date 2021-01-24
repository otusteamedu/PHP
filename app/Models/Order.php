<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * @property string status
 */
class Order extends Model
{
    protected string $table = 'order';

    protected array $fillable = [
        'status'
    ];
}
