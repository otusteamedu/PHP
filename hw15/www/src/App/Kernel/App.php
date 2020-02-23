<?php declare(strict_types=1);

namespace App\Kernel;

use App\Config\Config;
use App\Entities\OrderBuilder;
use App\Repository\Repository;

class App
{
    /**
     * @var \PDO
     */
    private static $pdo;
    /**
     * @var Request
     */
    private static $request;
    /**
     * @var Config
     */
    private static $config;

    /**
     * App constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        self::$config = new Config();
        self::$pdo = self::$config->createDbClient();
        self::$request = new Request();
    }

    public function run()
    {
        $repository = new Repository();

        $clientMapper = $repository->load('Client');

        $client = $clientMapper->findById((int) 'client_id');

        $orderBuilder = new OrderBuilder(
            $client
        );

        $productMapper = $repository->load('Product');

        $productByType = $productMapper->findByType('type');

        $couponMapper = $repository->load('Coupon');
        $coupon = $couponMapper->getById((int)'coupon_id');
        $orderBuilder->addCouponId($coupon);

        $product1 = $productMapper->findById((int) 'product_id_1');
        $product2 = $productMapper->findById((int) 'product_id_2');

        $orderBuilder->addProduct($product1);
        $orderBuilder->addProduct($product2);

        $deliveryServiceMapper = $repository->load('DeliveryService');
        $deliveryService = $deliveryServiceMapper->getById((int)'id');

        $orderBuilder->addDeliveryServiceList();

        $order = $orderBuilder->build();

        $orderMapper = $repository->load('Order');
        $orderMapper->insert($order);
    }

    /**
     * @param string $component
     * @return object
     * @throws \Exception
     */
    public function getInstance(string $component): object
    {
        if (!self::$$component) {
            throw new \Exception("Component {$component} not found");
        }

        return self::$$component;
    }
}