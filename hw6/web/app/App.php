<?php

/**
 * Class App - simple shop
 *
 * @author Petr Ivanov (petr.yrs@gmail.com)
 *
 * Этапы:
 *      1. создание корзины,
 *      2. добавление товаров,
 *      3. подтверждение заказа,
 *      4. выбор службы доставки
 *      5. установки скидки
 */

use models\User;
use models\Order;
use factory\ProdFactory;
use factory\DeliveryFactory;
use discounts\DisTotalPercent;

class App
{
    /**
     * @var Order
     */
    private $order;


    public function run()
    {
        $this->createBasket();
        $this->addProducts();
        $this->checkout();
        $this->setDiscount(5);
        $this->setDelivery('boxberry');
    }


    /**
     * Создаем корзину
     */
    private function createBasket()
    {
        $this->order = new Order();
    }


    /**
     * Добавляем товары
     *
     * @throws \Exception
     */
    private function addProducts()
    {
        $this->order->addProduct(new ProdFactory('apple'), 10);
        $this->order->addProduct(new ProdFactory('banana'), 5);
        $this->order->addProduct(new ProdFactory('orange'), 7);
        $this->order->addProduct(new ProdFactory('apple'), 4);
    }


    /**
     * Подтверждение заказа и привязка пользователя
     */
    private function checkout()
    {
        $user        = new User();
        $user->id    = 1;
        $user->email = 'petr.yrs@gmail.com';
        $user->nick  = 'Petr Ivanov';
        $this->order->checkOut($user);
    }


    /**
     * Применить скидку
     */
    private function setDiscount($procent)
    {
        $discount    = new DisTotalPercent($this->order, $procent);
        $this->order = $discount->getOrder();
    }


    /**
     * Установить доставку
     *
     * @param $name название службы доставки
     *
     * @return DeliveryFactory
     * @throws Exception
     */
    private function setDelivery($name)
    {
        $this->order->setDelivery(new DeliveryFactory($name));
    }
}