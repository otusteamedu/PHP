<?php


namespace App\price;


use App\price\schemes\DeliveryFree;
use App\price\schemes\SchemePrice;
use App\Product;
use App\Order;
use App\price\schemes\BaseScheme;
use App\price\schemes\Coupon;
use App\price\schemes\Discount;
use App\price\schemes\FreeProducts;

class CustomPricer extends Pricer
{

    public static function create(Order $order)
    {
        $base = new BaseScheme($order);
        $inst = new self($base);

        $schemes = [
            Discount::create($order, 10),
            Coupon::create($order, 100),
            (new FreeProducts($order))->addProduct(new Product(3, 50)),
            (new DeliveryFree($order))
        ];

        foreach ($schemes as $scheme)
            $inst->add($scheme);

        return $inst;
    }

}