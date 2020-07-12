<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'deliveryServices';
    public $id;
    public $name;
    public $price;
    public $size;
    public $priceWithDiscount;
    public $productDiscountId;
    public $type;
}