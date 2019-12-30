<?php


namespace App;
use App\InsertOrderBuilder;

/**
 * Class InsertOrder
 * @package App
 */
class InsertOrder
{
    /**
     * @var
     */
    public $name;
    /**
     * @var
     */
    public $couponId;
    /**
     * @var
     */
    public $fullPrice;
    /**
     * @var
     */
    public $typeId;
    /**
     * @var
     */
    public $deliveryServiceId;
    /**
     * @var
     */
    public $clientId;

    /**
     * InsertOrder constructor.
     * @param \App\InsertOrderBuilder $builder
     */
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