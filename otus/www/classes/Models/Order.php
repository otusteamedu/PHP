<?php

namespace Classes\Models;

class Order extends AbstractActiveRecord
{
    protected $id;
    protected $number;
    protected $cost;
    protected $products;
    protected $type;
    protected $status;
    protected $delivery;
    protected $discount;

    protected static $tableName = 'orders';

    public function getId()
    {
        return $this->id;
    }

    public function getNumber()
    {
        return $this->number;
    }
    public function getCost()
    {
        return $this->cost;
    }

    public function getProducts()
    {
        return json_decode($this->products, true, 512, JSON_THROW_ON_ERROR);
    }

    public function getType()
    {
        return $this->type;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getDelivery()
    {
        return $this->status;
    }

    public function getDiscount()
    {
        return $this->status;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function setNumber(int $number)
    {
        $this->number = $number;
    }

    public function setCost(float $cost)
    {
        $this->cost = $cost;
    }

    public function setProducts(string $products)
    {
        $this->products = $products;
    }

    public function setType(string $type)
    {
        $this->type = $type;
    }

    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    public function setDelivery(Delivery $delivery)
    {
        $this->delivery = $delivery;
    }

    public function setDiscount(Discount $discount)
    {
        $this->discount = $discount;
    }
}
