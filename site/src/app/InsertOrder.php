<?php


namespace App;
use App\InsertOrderBuilder;

class InsertOrder
{
    public $name;
    public $couponId;
    public $fullPrice;
    public $typeId;
    public $deliveryServiceId;
    public $clientId;
    public function __construct(InsertOrderBuilder $builder)
    {
$this->name=$builder->name;
$this->couponId=$builder->couponId;
$this->clientId=$builder->clientId;
$this->fullPrice=$builder->fullPrice;
$this->typeId=$builder->typeId;
$this->deliveryServiceId=$builder->deliveryServiceId;
    }

}