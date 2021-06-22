<?php
declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_UNCONFIRMED = 1;

    protected $fillable = [
        'name', 'status',
    ];

    protected $attributes = [
        'status' => self::STATUS_UNCONFIRMED,
    ];

    public function getCreatedAtAttribute(string $date): string
    {
        return Carbon::createFromDate($date)->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute(string $date): string
    {
        return Carbon::createFromDate($date)->format('Y-m-d H:i:s');
    }
}
