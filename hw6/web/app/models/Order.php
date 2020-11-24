<?php
/**
 * Заказ/корзина
 *
 * @author Petr Ivanov (petr.yrs@gmail.com)
 */

namespace models;

use discounts\IDiscount;
use factory\IDelivery;
use Google\Exception;
use SplObjectStorage;

class Order
{
    /**
     * @var float Общая сумма заказа
     */
    public $totalCost = 0;
    /**
     * @var SplObjectStorage Товары
     */
    private $products;
    /**
     * @var bool Заказ не подтвержден - это корзина
     */
    private $isBasket  = true;
    /**
     * @var User
     */
    private $orderUser;
    /**
     * @var float Размер скидки в процентах
     */
    private $discount;
    /**
     * @var
     */
    private $delivery;


    public function __construct()
    {
        $this->products = new SplObjectStorage();
    }


    /**
     * Подтверждение заказа
     */
    public function checkOut(User $user)
    {
        $this->addUser($user);
        $this->isBasket = false;
    }


    /**
     * Добавить товар в заказ
     *
     * @param Product $product товар
     * @param int     $count   кол-во
     *
     * @throws Exception
     */
    public function addProduct(Product $product, int $count)
    {
        if ($count < 1) {
            throw new Exception('Кол-во должно быть больше нуля');
        }
        if ($this->products->contains($product)) {
            // если товар уже есть, то добавляем кол-во
            $c                        = $this->products->offsetGet($product);
            $this->products[$product] = $c + $count;
        } else {
            // товара нет в корзине
            $this->products->attach($product);
            $this->products[$product] = $count;
        }
        $this->calcTotal();
    }


    /**
     * Подсчет суммы заказа
     */
    private function calcTotal()
    {
        $this->totalCost = 0;
        $this->products->rewind();
        while ($this->products->valid()) {
            $product         = $this->products->current();
            $count           = $this->products->getInfo();
            $this->totalCost += $product->retailCost * $count;

            $this->products->next();
        }
        if ( ! empty($this->discount)) {
            $discount        = ($this->totalCost * $this->discount) / 100;
            $this->totalCost = $this->totalCost - $discount;
        }
    }


    /**
     * Удалаем заданное кол-во товара
     *
     * @param Product $product товар
     * @param int     $count   кол-во
     *
     * @throws Exception
     */
    public function removeProduct(Product $product, int $count)
    {
        if ($count < 1) {
            throw new Exception('Кол-во должно быть больше нуля');
        }
        if ($this->products->contains($product)) {
            // текущее кол-во товара в заказе
            $c = $this->products->offsetGet($product);
            $c = $c - $count;
            if ($c < 1) {
                $this->products->detach($product);
            } else {
                $this->products[$product] = $c;
            }
            $this->calcTotal();
        }
    }


    /**
     * Получить товары из заказа
     * @return array
     */
    public function getProducts(){
        $res = [];
        $this->products->rewind();
        while ($this->products->valid()) {
            $product         = $this->products->current();
            $count           = $this->products->getInfo();

            $res[] = [
                'product' => $product,
                'count' => $count
            ];

            $this->products->next();
        }
        return $res;
    }


    /**
     * Установить скидку на товар
     * @param Product $product
     * @param float   $discount
     *
     * @throws Exception
     */
    public function setProductDiscount(Product $product, float $discount){
        if (!$this->products->contains($product)) {
            throw new Exception('Product not found');
        }
        $prod = $this->products->offsetGet($product);
        $prod->setDiscount($discount);
        $this->calcTotal();
    }

    /**
     * Удалить все товары
     */
    public function clear()
    {
        (new SplObjectStorage())->removeAll($this->products);
        $this->products  = new SplObjectStorage();
        $this->totalCost = 0;
    }


    /**
     * Установить скидку в процентах
     *
     * @param float $discount
     */
    public function setDiscount(float $discount)
    {
        $this->discount = $discount;
        $this->calcTotal();
    }


    /**
     * Получить размер скидки в процентах
     * @return float
     */
    public function getDiscount(){
        return $this->discount;
    }


    /**
     * Установить пользователя
     *
     * @param User $user
     */
    private function addUser(User $user)
    {
        $this->orderUser = $user;
    }


    /**
     * Получить пользователя
     *
     * @return mixed
     */
    public function getUser()
    {
        return $this->orderUser;
    }


    /**
     * Установить службу доставки
     * @param IDelivery $delivery
     */
    public function setDelivery(IDelivery $delivery){
        $this->delivery = $delivery;
    }


    /**
     * Получить службу доставки
     * @return mixed
     */
    public function getDelivery(){
        return $this->delivery;
    }
}