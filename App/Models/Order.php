<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'price'
    ];
    public $timestamps = false;

    public const STATUS = [
        'NEW'    => 'N',
        /**...*/
        'CLOSED' => 'F'
    ];

    public function getKeyType()
    {
        return 'string';
    }
}

