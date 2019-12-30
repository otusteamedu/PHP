<?php


namespace App;


/**
 * Class Product
 * @package App
 */
class Product
{
    /**
     * @var
     */
    private $id;
    /**
     * @var
     */
    private $name;
    /**
     * @var
     */
    private $discount_product_id;
    /**
     * @var
     */
    private $price;
    /**
     * @var
     */
    private $orderId;

    /**
     * @return mixed
     */
    public function  getId(){

  return  $this->id;
}

    /**
     * @param $id
     */
    public function setId($id){
    $this->id=$id;
}

    /**
     * @return mixed
     */
    public function getName(){
    return $this->name;
}

    /**
     * @param $name
     */
    public function setName($name){
    $this->name=$name;

}

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param mixed $orderId
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * @param $discount_product_id
     */
    public function setDiscount_product_id($discount_product_id){
     $this->discount_product_id=$discount_product_id;
   }

    /**
     * @return mixed
     */
    public function getDiscount_product_id(){
      return $this->discount_product_id;
    }

    /**
     * @return mixed
     */
    public function getPrice(){
    return $this->price;
}

    /**
     * @param $price
     */
    public function setPrice($price){
        $this->price=$price;
    }

    /**
     * Product constructor.
     * @param $id
     * @param $name
     * @param $orderId
     * @param $discount_product_id
     * @param $price
     */
    public function __construct($id, $name, $orderId, $discount_product_id, $price)
    {
        $this->id=$id;
        $this->name=$name;
        $this->orderId=$orderId;
        $this->discount_product_id=$discount_product_id;
        $this->price=$price;
    }
}
