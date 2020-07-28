<?php

namespace Classes\Dto;


class OrderDto
{
    public $id;
    public $number;
    public $cost;
    public $products;
    public $type;
    public $status;
    public $discount;
    public $delivery;
    public $userId;

    public static function build(OrderDtoBuilder $builder)
    {
        $self = new self();
        $self->id = $builder->getId();
        $self->number = $builder->getNumber();
        $self->cost = $builder->getCost();
        $self->products = $builder->getProducts();
        $self->type = $builder->getType();
        $self->status = $builder->getStatus();
        $self->discount = $builder->getDiscount();
        $self->delivery = $builder->getDelivery();
        $self->userId = $builder->getUserId();

        return $self;
    }
}
