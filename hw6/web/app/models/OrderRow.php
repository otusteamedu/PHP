<?php

namespace models;

use discounts\IDiscountRow;

class OrderRow implements IOrderRow
{
    /**
     * @var float Кол-во
     */
    public $count = 0;
    /**
     * @var float отпускная цена
     */
    public $cost  = 0;
    /**
     * @var float Итого по строке
     */
    public $total = 0;
    /**
     * @var IDiscountRow Скидка
     */
    protected $discount;


    /**
     * OrderRow constructor.
     *
     * @param float $count Кол-во товара
     * @param float $cost Отпускная цена товара
     */
    public function __construct($count, $cost){
        $this->count = $count;
        $this->cost = $cost;
    }

    /**
     * Расчет строки
     */
    public function calc()
    {
        $this->total = $this->count * $this->cost;
        if ( ! empty($this->discount) && is_object($this->discount)) {
            $this->discount->calcRow($this);
        }

        return $this->total;
    }

    public function setDiscount(IDiscountRow $discount) {
        $this->discount = $discount;
    }

    public function getDiscount(){
        return $this->discount;
    }
}