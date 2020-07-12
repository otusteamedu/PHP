<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryServiceDiscount extends Model
{
    protected $table = 'deliveryServices';
    public $id;
    public $discount;
}