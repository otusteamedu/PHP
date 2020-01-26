<?php


namespace App;


/**
 * Class Client
 * @package App
 */
class Client
{
    /**
     * @var
     */
    private $id;
    /**
     * @var
     */
    private $nameClient;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param $nameClient
     */
    public function setNameClient($nameClient)
    {
        $this->nameClient = $nameClient;
    }

    /**
     * @return mixed
     */
    public function getMameClient()
    {
        return $this->nameClient;
    }

    /**
     * Client constructor.
     * @param $id
     * @param $nameClient
     */
    public function __construct($id, $nameClient)
    {
        $this->id = $id;
        $this->nameClient = $nameClient;
    }
}
