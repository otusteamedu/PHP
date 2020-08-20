<?php

use App\Otus\PatternsAlgorithms\Discounts\CouponDiscount;
use App\Otus\PatternsAlgorithms\Discounts\FreeDeliveryDiscount;
use App\Otus\PatternsAlgorithms\Discounts\PercentageDiscount;
use App\Otus\PatternsAlgorithms\Discounts\TwoForPriceOfOneDiscount;
use App\Otus\PatternsAlgorithms\Orders\B2BOrder;
use App\Otus\PatternsAlgorithms\Package;
use App\Otus\PatternsAlgorithms\Products\ProductOne;
use App\Otus\PatternsAlgorithms\Products\ProductTwo;
use App\Otus\PatternsAlgorithms\Shipments\DHLShipment;
use App\Otus\PatternsAlgorithms\Shipments\UPSShipment;
use App\Otus\PatternsAlgorithms\Users\Customer;

require __DIR__ . '/../../../vendor/autoload.php';

// create customer
$customer = new Customer();
$customer->setName('Vasya Pupkin');

// create products
$productOne = new ProductOne();
$productOne->setPrice(10.99);
$productTwo = new ProductTwo();
$productTwo->setPrice(20.99);

// create order and add products
$itemOne = $productOne;
$itemTwo = $productOne;
$itemThree = $productTwo;

$order = new B2BOrder($itemOne);
$order->setCustomer($customer);
$order->addProduct($itemTwo);
$order->addProduct($itemThree);

// configure two packages (1 item in first package, 2 items in second package)
$packageOne = new Package();
$packageOne->addProduct($itemOne);
$packageOne->addProduct($itemTwo);

$packageThree = new Package();
$packageThree->addProduct($productTwo);

// configure shipment for the packages
$shipmentOne = new UPSShipment();
$shipmentOne->addPackage($packageOne);

$shipmentTwo = new DHLShipment();
$shipmentTwo->addPackage($packageThree);

// add shipments to the order
$order->addShipment($shipmentOne);
$order->addShipment($shipmentTwo);

// add discounts to order
$discountOne=new PercentageDiscount(0.05);
$discountOne->setName('Loyalty discount (5%)');

$discountTwo=new PercentageDiscount(0.03);
$discountTwo->setName('Christmas discount (3%)');

$discountThree = new CouponDiscount(5);
$discountThree->setName('Savings coupon');

$discountFour = new FreeDeliveryDiscount();
$discountFour->setName('Free delivery');

$order->addDiscount($discountOne);
$order->addDiscount($discountTwo);
$order->addDiscount($discountThree);
$order->addDiscount($discountFour);

/*************************************/
/*************************************/
$order->calculateTotals();
/*************************************/
/*************************************/

// print receipt
echo PHP_EOL;
echo 'ORDER' . PHP_EOL;
echo '=====' . PHP_EOL;

echo 'Customer: ' . $order->getCustomer()->getName() . PHP_EOL;
echo 'Order type: ' . $order->getName() . PHP_EOL;
echo PHP_EOL;

echo 'Products' . PHP_EOL;
echo '--------' . PHP_EOL;
foreach ($order->getProducts() as $product) {
    echo 'Product: ' . $product->getName() . ' - $' . $product->getPrice() . PHP_EOL;
}

echo 'Products price: $' . $order->getProductsSubtotal() . PHP_EOL;
echo PHP_EOL;

echo 'Shipment' . PHP_EOL;
echo '--------' . PHP_EOL;
foreach ($order->getShipments() as $shipment) {
    echo 'Shipment: ' . $shipment->getName() . ' - ' .
        count($shipment->getPackages()) . ' package(s) - '.
        count($shipment->getProducts()). ' product(s) - $ ' .
        $shipment->shipmentPrice() . PHP_EOL;
}
echo 'Total shipment price: '.$order->getShipmentSubtotal().PHP_EOL;

echo PHP_EOL.'Price before discounts: $' . $order->getSubtotalBeforeDiscounts();
echo PHP_EOL.'----------------------'.PHP_EOL;
echo PHP_EOL;

// TODO: moar discounts...

echo 'Discounts' . PHP_EOL;
echo '--------' . PHP_EOL;
foreach ($order->getDiscounts() as $discount) {
    echo 'Discount: ' . $discount. PHP_EOL;
}
echo 'Savings: $' . $order->getDiscountSubtotal() . PHP_EOL;
echo PHP_EOL;

echo '===========' . PHP_EOL;
echo 'Final price: $' . $order->getFinalPrice() . PHP_EOL;
echo '===========' . PHP_EOL;