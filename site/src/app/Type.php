<?php


namespace App;


/**
 * Class Type
 * @package App
 */
class Type
{
    /**
     * @var
     */
    private $id;
    /**
     * @var
     */
    private $nameType;

    /**
     * @return mixed
     */
    public function  getId(){
        return $this->id;

    }

    /**
     * @param $id
     */
    public function  setId($id){
        $this->id=$id;
    }

    /**
     * @return mixed
     */
    public function  getName_type(){
        return $this->nameType;
    }

    /**
     * @param $nameType
     */
    public function  setNameType($nameType){
        $this->nameType= $nameType;
    }

    /**
     * Type constructor.
     * @param $id
     * @param $nameType
     */
    public function  __construct($id, $nameType)
    {
        $this->id=$id;
        $this->nameType=$nameType;
    }

}