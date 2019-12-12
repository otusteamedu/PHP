<?php


namespace App;


class Client
{
    private $id;
    private $nameClient;
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setNameClient($nameClient)
    {
        $this->nameClient = $nameClient;
    }
    public function getMameClient()
    {
        return $this->nameClient;
    }
    public function __construct($id, $nameClient)
    {
        $this->id = $id;
        $this->nameClient = $nameClient;
    }
}
