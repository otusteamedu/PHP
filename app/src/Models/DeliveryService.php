<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryService extends Model
{
    protected $table = 'deliveryServices';
    public $id;
    public $name;
    public $tariff;
    public $deliveryDiscountId;
    public $priceWithDiscount;
    public $maxSize;

    public function calculatePriceWithDiscount($discount): void
    {
        return; // стоимость с вычетом скидок
    }
}