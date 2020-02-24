<?php

namespace App\Entities;

class OrderEntity extends BaseEntity
{
    protected $id;
    protected $name;
    protected $clientId;
    protected $couponId;
    protected $priceRub;
    protected $productList = array();
    protected $deliveryPackageList = array();

    public function __construct(OrderBuilder $orderBuilder)
    {
        $this->id = $orderBuilder->id;
        $this->name = $orderBuilder->name;
        $this->clientId = $orderBuilder->clientId;
        $this->couponId = $orderBuilder->couponId;
        $this->priceRub = $orderBuilder->priceRub;
        $this->productList = $orderBuilder->productList;
        $this->deliveryPackageList = $orderBuilder->deliveryServiceList;
    }

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
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param mixed $clientId
     */
    public function setClientId($clientId): void
    {
        $this->clientId = $clientId;
    }

    /**
     * @return mixed
     */
    public function getCouponId()
    {
        return $this->couponId;
    }

    /**
     * @param mixed $couponId
     */
    public function setCouponId($couponId): void
    {
        $this->couponId = $couponId;
    }

    /**
     * @return mixed
     */
    public function getPriceRub()
    {
        return $this->priceRub;
    }

    /**
     * @param mixed $priceRub
     */
    public function setPriceRub($priceRub): void
    {
        $this->priceRub = $priceRub;
    }

    /**
     * @return array
     */
    public function getProductList(): array
    {
        return $this->productList;
    }

    /**
     * @param array $productList
     */
    public function setProductList(array $productList): void
    {
        $this->productList = $productList;
    }

    /**
     * @return array
     */
    public function getDeliveryPackageList(): array
    {
        return $this->deliveryPackageList;
    }

    /**
     * @param array $deliveryPackageList
     */
    public function setDeliveryPackageList(array $deliveryPackageList): void
    {
        $this->deliveryPackageList = $deliveryPackageList;
    }

    public function calculateFullPrice() {
        // todo вычисление полной стоимости заказа
    }
}