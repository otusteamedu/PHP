<?php

namespace models;

class Product
{
    /**
     * @var int ID-товара
     */
    public $id;
    /**
     * @var string Название товара
     */
    public $name;
    /**
     * @var float Цена товара
     */
    public $cost = 0;
    /**
     * @var float Скидка на товар в процентах
     */
    public $discount = 0;
    /**
     * @var float Цена товара со скидкой
     */
    public $retailCost = 0;


    /**
     * Рассчитать цену с учетом скидки
     *
     * @return $this
     */
    private function calcRetailCost()
    {
        $discount         = ($this->cost * $this->discount) / 100;
        $this->retailCost = $this->cost - $discount;

        return $this;
    }


    /**
     * Установить цену
     *
     * @param float $cost
     */
    public function setCost(float $cost)
    {
        $this->cost = $cost;
        $this->calcRetailCost();

        return $this;
    }


    /**
     * Получить цену без скидки
     *
     * @return float
     */
    public function getCost()
    {
        return $this->cost;
    }


    /**
     * Установка скидки в процентах
     *
     * @param float $discount
     *
     * @return $this
     */
    public function setDiscount(float $discount)
    {
        $this->discount = $discount;
        $this->calcRetailCost();

        return $this;
    }


    /**
     * Получить размер скидки в процентах
     *
     * @return float
     */
    public function getDiscount()
    {
        return $this->discount;
    }
}