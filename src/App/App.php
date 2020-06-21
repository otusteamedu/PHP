<?php

namespace Ozycast\App;

use Ozycast\App\Core\Db;
use Ozycast\App\Core\DbMySQL;
use Ozycast\App\Mappers\ClientMapper;
use Ozycast\App\Models\OrderBuilder;
use Ozycast\App\Models\Order;

Class App
{
    public static $db = null;

    public function __construct()
    {
        self::getDb();
    }

    public function run()
    {
        // Авторизовался клиент
        $client = (new ClientMapper(App::$db))->findOne(['id' => 1]);

        $builder = new OrderBuilder($client);

        $builder->addProduct(1, 2)
                ->addProduct(2, 1)
                ->addProduct(3, 4)
                ->setDelivery(2)
                ->setDiscount(1)
                ->calculate();

        // Записываем заказ в БД.
        $order = (new Order())->createOrder($builder);

        // Отправляем товар в доставку
        // В зависимости от доставщика сортируем товар по посылкам
        $order->inDelivery();
        $this->showMessage("Done!");
    }

    public function getDb(): Db
    {
        self::$db = (new DbMySQL())->connect();
        return self::$db;
    }

    public function showMessage($message, $data = [])
    {
        print_r($message."\n\r");
        print_r($data);
    }
}
