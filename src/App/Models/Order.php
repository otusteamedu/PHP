<?php

namespace Ozycast\App\Models;

use Ozycast\App\App;
use Ozycast\App\Mappers\OrderMapper;
use Ozycast\App\Mappers\ProductOrderMapper;

Class Order
{
    /**
     * @var \Ozycast\App\DTO\Order
     */
    public $order;

    /**
     * @var array
     */
    public $productOrder;

    /**
     * @param OrderBuilder $builder
     *
     * @return $this
     * @throws \Exception
     */
    public function createOrder(OrderBuilder $builder)
    {
        $this->order = (new OrderMapper(App::$db))->insert($builder->getOrder());

        foreach ($builder->getProductOrder() as $productOrder) {
            $productOrder->setOrderId($this->order->getId());
            $this->productOrder[] = (new ProductOrderMapper(App::$db))->insert($productOrder);
        }

        return $this;
    }

    /**
     * В доставку, распределить товары по послыкам
     */
    public function inDelivery()
    {
        $parcel = new OrderParcel($this);
    }

    /**
     * Вернет данные заказа
     * @param $id
     * @return \Ozycast\App\Core\DTO|null
     */
    public static function getOrder($id)
    {
        $order = (new OrderMapper(App::$db))->findOne(['id' => $id]);
        return $order;
    }

    /**
     * Изменить статус заказа
     * @param int $order_id
     * @param int $status
     * @throws \Exception
     */
    public static function setStatus(int $order_id, int $status)
    {
        $order = Order::getOrder($order_id);
        $order->setStatus($status);
        $order = (new OrderMapper(App::$db))->update($order);
    }
}