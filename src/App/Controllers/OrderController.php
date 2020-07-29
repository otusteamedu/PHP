<?php

namespace Ozycast\App\Controllers;

use Ozycast\App\App;
use Ozycast\App\Core\Controller;
use Ozycast\App\DTO\Queue\OrderQueueDTO;
use Ozycast\App\Models\Order;
use Ozycast\App\Models\Queue\QueueOrders;

class OrderController extends Controller
{
    /**
     * Включим авторизовываем клиента
     * @var bool
     */
    public static $auth = true;
    const MODEL = "Order";

    /**
     * Детальная информация
     * @param $id
     */
    public function actionShow($id)
    {
        $order = Order::getOrder($id);
        $this->response->send(true, [self::MODEL => $order->toArray()]);
    }

    /**
     * Добавления заказа
     * @throws \Exception
     */
    public function actionCreate()
    {
        $order = Order::collectOrder(App::getUser(), $_POST);

        // Добавим заказ в очередь на обработку
        $dto = new OrderQueueDTO($order->order->getId());
        QueueOrders::add($dto->toString());

        $this->response->send(true, [self::MODEL => $order->order->toArray()]);
    }

    /**
     * Очередью
     * "Обработаем" заказ и изменим статус
     * @param $params
     * @throws \Exception
     */
    public function actionProcess($params)
    {
        sleep(rand(15, 60));
        Order::setStatus($params['order_id'], 2);
    }
}
