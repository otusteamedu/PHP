<?php


namespace App;


class Order
{
private $id;
private $name;
private $type_id;
private  $client_id;
private $full_price;
private  $coupon_id;
private  $delivery_service_id;
public  function setId($id){
    $this->id=$id;
}
public function getId(){
    return $this->id;
}
public function getDelivery_service_id(){
    return $this->delivery_service_id;
}
    public function setDelivery_service_id($delivery_service_id){
        $this->delivery_service_id=$delivery_service_id;
    }
    public  function setName($name){
        $this->name=$name;
    }
public function getName(){
    return $this->name;
}
public  function setType_id($type_id){
    $this->type_id=$type_id;
}
    public  function getType_id(){
     return   $this->type_id;
    }
public function setClient_id($client_id){
    $this->client_id=$client_id;
}

public  function  getClient_id(){
    return $this->client_id;

}
public function setFull_price($full_price){
    $this->full_price=$full_price;
}

public function getFull_price(){

    return $this->full_price;
}
public  function  getCoupon_id(){
    return $this->coupon_id;

}
public function setCoupon_id($coupon_id){
    $this->coupon_id=$coupon_id;

}

public function __construct($id,$name,$coupon_id,$full_price,$type_id,$delivery_service_id,$client_id)
{
$this->id=$id;
$this->name=$name;
$this->coupon_id=$coupon_id;
$this->full_price=$full_price;
$this->type_id=$type_id;
$this->delivery_service_id=$delivery_service_id;
$this->client_id=$client_id;

}

}