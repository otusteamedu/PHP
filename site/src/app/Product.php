<?php


namespace App;


class Product
{
private $id;
private $name;
private $discount_product_id;
private $price;
private $orderId;

public function  getId(){

  return  $this->id;
}
public function setId($id){
    $this->id=$id;
}
public function getName(){
    return $this->name;
}
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

public function setDiscount_product_id($discount_product_id){
     $this->discount_product_id=$discount_product_id;
}
public function getDiscount_product_id(){
return $this->discount_product_id;
}
public function getPrice(){
    return $this->price;
}
    public function setPrice($price){
        $this->price=$price;
    }
    public function __construct($id,$name,$orderId,$discount_product_id,$price)
    {
        $this->id=$id;
        $this->name=$name;
        $this->orderId=$orderId;
        $this->discount_product_id=$discount_product_id;
        $this->price=$price;
    }
}
