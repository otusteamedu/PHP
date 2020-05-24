<?php


namespace App;


class Product
{
    private $id;
    private $price;
    private $packageID;

    public function __construct($id, $price)
    {
        $this->id = $id;
        $this->price = $price;
    }

    /**
     * @param mixed $packageID
     */
    public function setPackageID($packageID)
    {
        $this->packageID = $packageID;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPackageID()
    {
        return $this->packageID;
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
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

}