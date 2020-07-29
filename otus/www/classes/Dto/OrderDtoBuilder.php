<?php

namespace Classes\Dto;


class OrderDtoBuilder
{
    private $errors;

    private $id;
    private $number;
    private $cost;
    private $products;
    private $type;
    private $status;
    private $discountType;
    private $delivery;
    private $userId;

    public function setId(?int $id)
    {
        $this->id = $id;
        return $this;
    }

    public function setNumber(?int $number)
    {
        $this->number = $number;
        return $this;
    }

    public function setCost (int $cost)
    {
        $this->cost = $cost;
        return $this;
    }

    public function setProducts (string $products)
    {
        $this->products = $products;
        return $this;
    }

    public function setType (string $type)
    {
        $this->type = $type;
        return $this;
    }

    public function setStatus (string $status)
    {
        $this->status = $status;
        return $this;
    }

    public function setDelivery (?int $deliveryId)
    {
        $this->delivery = $deliveryId;
        return $this;
    }

    public function setDiscountType (?string $discountType)
    {
        $this->discountType = $discountType;
        return $this;
    }

    public function setUserId(int $userId)
    {
        $this->userId = $userId;
        return $this;
    }


    public function build()
    {
        $this->validate();

        if (!empty($this->errors)) {
            throw new \RuntimeException(implode(';', $this->errors));
        }
        return OrderDto::build($this);
    }

    public function validate()
    {
        if (empty($this->cost)) {
            $this->errors[] = 'Не задана стоимость заказа';
        }

        if (empty($this->products)) {
            $this->errors[] = 'Не переданы id товаров';
        }

        if (empty($this->type)) {
            $this->errors[] = 'Не задан тип заказа';
        }

        if (empty($this->status)) {
            $this->errors[] = 'Не задан статус заказа';
        }


        if (empty($this->userId)) {
            $this->errors[] = 'Не передан пользователь для заказа';
        }

    }

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
        return $this->products;
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
        return $this->delivery;
    }

    public function getDiscountType()
    {
        return $this->discountType;
    }
    public function getUserId()
    {
        return $this->userId;
    }

}
