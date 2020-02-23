<?php

namespace App\Entities;

class DeliveryServiceEntity extends BaseEntity
{
    protected $id;
    protected $name;
    protected $tariff;
    protected $deliveryDiscountId;
    protected $priceWithDiscount;
    protected $maxSize;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getTariff()
    {
        return $this->tariff;
    }

    /**
     * @param mixed $tariff
     */
    public function setTariff($tariff): void
    {
        $this->tariff = $tariff;
    }

    /**
     * @return mixed
     */
    public function getMaxSize()
    {
        return $this->maxSize;
    }

    /**
     * @param mixed $maxSize
     */
    public function setMaxSize($maxSize): void
    {
        $this->maxSize = $maxSize;
    }

    /**
     * @return mixed
     */
    public function getPriceWithDiscount()
    {
        return $this->priceWithDiscount;
    }

    /**
     * @param mixed $priceWithDiscount
     */
    public function setPriceWithDiscount($priceWithDiscount): void
    {
        $this->priceWithDiscount = $priceWithDiscount;
    }

    /**
     * @param mixed $priceWithDiscount
     */
    public function calculatePriceWithDiscount($priceWithDiscount): void
    {
        // todo вычисление стоимости с вычетом скидок
    }

    /**
     * @return mixed
     */
    public function getDeliveryDiscountId()
    {
        return $this->deliveryDiscountId;
    }

    /**
     * @param mixed $deliveryDiscountId
     */
    public function setDeliveryDiscountId($deliveryDiscountId): void
    {
        $this->deliveryDiscountId = $deliveryDiscountId;
    }
}