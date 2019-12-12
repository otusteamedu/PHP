<?php


$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

use App\Factory;

class App
{
    public static function init()

    {
        $factory = new Factory();
        $type = $_POST['type']['id'] = 1;
        $client = $_POST['client']['id'] = 1;
        $coupon = $_POST['coupon']['id'] = 1;
        $deliveryService = $_POST['DeliverService']['id'] = 1;
        $products = $_POST['products']['ids'] = [1, 2, 3, 4, 5, 6];
        $name = $_POST['name'] = 'name';

        $Order = $factory->create('Order');
        $Type = $factory->create('Type');
        $Client = $factory->create('Client');
        $Coupon = $factory->create('Coupon');
        $DeliverService = $factory->create('DeliverService');
        $Product = $factory->create('Product');
        $DiscountDeliveryService=$factory->create('DiscountDeliveryService');

        $idType = $Type->findById($type)->getId();
        $idClient = $Client->findById($client)->getId();
        $idCoupon = $Coupon->findById($coupon)->getId();
        $idDeliverService = $DeliverService->findById($deliveryService)->getId();
        $discountCouponCoefficient = $Coupon->findById($coupon)->getDiscountCouponCoefficient();
        $discountCouponRub = $Coupon->findById($coupon)->getDiscountCouponRub();
        foreach ($products as $key => $value) {
            $priceProducts[] = $Product->findByPriceId($value)->getProductsPrice();
        }
        $priceDeliverService = $DeliverService->findByPriceId($deliveryService)->getDeliveryServicePrice();
        $fullPrice = ($factory->create('FullPriceBuilder'))
            ->addDiscountCouponCoefficient($discountCouponCoefficient)
            ->addDiscountCouponRub($discountCouponRub)
            ->addProductPrice($priceProducts)
            ->addDeliveryPrice($priceDeliverService)
            ->countPrice()
            ->build();
        $price = $fullPrice->orderPrice;
        $InsertOrder = ($factory->create('InsertOrderBuilder'))
            ->addClientId($idClient)
            ->addCouponId($idCoupon)
            ->addName($name)
            ->addDeliveryServiceId($idDeliverService)
            ->addTypeId($idType)
            ->addFullPrice($price)
            ->build();

        $Order->insert([
            'name_order' => $InsertOrder->name,
            'full_price' => $InsertOrder->orderPrice,
            'coupon_id' => $InsertOrder->couponId,
            'client_id' => $InsertOrder->clientId,
            'delivery_service_id' => $InsertOrder->deliveryServiceId,
            'type_id' => $InsertOrder->typeId


        ]);
    }
}
