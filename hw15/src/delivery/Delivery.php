<?php


namespace App\delivery;


class Delivery
{
    private $id;
    private $price;

    public function __construct($id, $price = 0)
    {
        $this->id = $id;
        $this->price = $price;
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
     * @return Delivery
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     * @return Delivery
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }



}