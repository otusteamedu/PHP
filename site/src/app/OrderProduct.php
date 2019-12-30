<?php


namespace App;


/**
 * Class OrderProduct
 * @package App
 */
class OrderProduct
{
    /**
     * @var
     */
    private $id;
    /**
     * @var
     */
    private $orderId;
    /**
     * @var
     */
    private $productId;

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param mixed $productId
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
    }

    /**
     * @param mixed $orderId
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * OrderProduct constructor.
     * @param $id
     * @param $orderId
     * @param $productId
     */
    public function __construct($id, $orderId, $productId)
    {
        $this->id=$id;
        $this->orderId=$orderId;
        $this->productId=$productId;
    }


}