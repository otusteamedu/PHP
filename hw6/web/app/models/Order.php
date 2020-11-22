<?php
/**
 * Заказ/корзина
 *
 * @author Petr Ivanov (petr.yrs@gmail.com)
 */

namespace models;

use discounts\IDiscount;
use Google\Exception;
use SplObjectStorage;

class Order
{
    private $products;
    private $isBasket  = true;
    private $totalCost = 0;
    /**
     * @var User
     */
    private $orderUser;
    /**
     * @var IDiscount
     */
    private $discount;


    public function __construct()
    {
        $this->products = new SplObjectStorage();
    }


    public function checkOut()
    {
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
        $this->reCalcTotal();
    }


    /**
     * Подсчет суммы заказа
     */
    private function reCalcTotal()
    {
        $this->totalCost = 0;
        $this->products->rewind();
        while ($this->products->valid()) {
            $product         = $this->products->current();
            $count           = $this->products->getInfo();
            $this->totalCost += $product->cost * $count;

            $this->products->next();
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
            $this->reCalcTotal();
        }
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
     * Добавить скидку
     * @param IDiscount $discount
     */
    public function addDiscount(IDiscount $discount)
    {
        $this->discount = $discount;
    }


    /**
     * Установить пользователя
     * @param User $user
     */
    public function addUser(User $user){
        $this->orderUser = $user;
    }


    /**
     * Получить пользователя
     * @return mixed
     */
    public function getUser(){
        return $this->orderUser;
    }
}