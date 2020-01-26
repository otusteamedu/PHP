<?php


namespace App;


/**
 * Class Order
 * @package App
 */
class Order
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
    private $type_id;
    /**
     * @var
     */
    private  $client_id;
    /**
     * @var
     */
    private $full_price;
    /**
     * @var
     */
    private  $coupon_id;
    /**
     * @var
     */
    private  $delivery_service_id;

    /**
     * @param $id
     */
    public  function setId($id){
    $this->id=$id;
}

    /**
     * @return mixed
     */
    public function getId(){
    return $this->id;
}

    /**
     * @return mixed
     */
    public function getDelivery_service_id(){
    return $this->delivery_service_id;
}

    /**
     * @param $delivery_service_id
     */
    public function setDelivery_service_id($delivery_service_id){
        $this->delivery_service_id=$delivery_service_id;
    }

    /**
     * @param $name
     */
    public  function setName($name){
        $this->name=$name;
    }

    /**
     * @return mixed
     */
    public function getName(){
    return $this->name;
}

    /**
     * @param $type_id
     */
    public  function setType_id($type_id){
    $this->type_id=$type_id;
}

    /**
     * @return mixed
     */
    public  function getType_id(){
     return   $this->type_id;
    }

    /**
     * @param $client_id
     */
    public function setClient_id($client_id){
    $this->client_id=$client_id;
}

    /**
     * @return mixed
     */
    public  function  getClient_id(){
    return $this->client_id;

}

    /**
     * @param $full_price
     */
    public function setFull_price($full_price){
    $this->full_price=$full_price;
}

    /**
     * @return mixed
     */
    public function getFull_price(){

    return $this->full_price;
}

    /**
     * @return mixed
     */
    public  function  getCoupon_id(){
    return $this->coupon_id;

}

    /**
     * @param $coupon_id
     */
    public function setCoupon_id($coupon_id){
    $this->coupon_id=$coupon_id;

}

    /**
     * Order constructor.
     * @param $id
     * @param $name
     * @param $full_price
     * @param $coupon_id
     * @param $client_id
     * @param $delivery_service_id
     * @param $type_id
     */
    public function __construct($id, $name, $full_price, $coupon_id, $client_id, $delivery_service_id, $type_id)
{

$this->id=$id;
$this->name=$name;
$this->full_price=$full_price;
$this->coupon_id=$coupon_id;

$this->type_id=$type_id;
$this->delivery_service_id=$delivery_service_id;
$this->client_id=$client_id;

}

}