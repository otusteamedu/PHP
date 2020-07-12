<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'deliveryServices';
    public $id;
    public $name;
    public $clientId;
    public $couponId;
    public $price;
    public $productList = [];
    public $deliveryPackageList = [];

    public function calculateFullPrice() {
        // вычисление полной стоимости заказа
    }
}