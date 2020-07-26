<?php

namespace Ozycast\App\Controllers;

use Ozycast\App\Core\Controller;
use Ozycast\App\DTO\Queue\OrderQueueDTO;
use Ozycast\App\Models\Client;
use Ozycast\App\Models\Order;
use Ozycast\App\Models\OrderBuilder;
use Ozycast\App\Models\OrderStatus;
use Ozycast\App\Models\Queue\QueueOrders;

class OrderController extends Controller
{
    /**
     * Главная
     */
    public function actionIndex()
    {
        $this->view->generate('order/index');
    }

    /**
     * Страница добавления заказа
     * @throws \Exception
     */
    public function actionAdd()
    {
        $client = Client::getClient(1);

        // Получили данные из формы, добавим заказ
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

        // Добавим заказ в очередь на обработку
        $dto = new OrderQueueDTO($order->order->getId());
        QueueOrders::add($dto->toString());

        $this->view->generate('order/added', [
            'order_id' => $order->order->getId(),
        ]);
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

    /**
     * Страница просмотра статуса
     */
    public function actionStatus()
    {
        $order = Order::getOrder($_GET['id']);

        $this->view->generate('order/status', [
            'order' => $order,
            'status' => OrderStatus::getStatus($order->getStatus())
        ]);
    }

}
