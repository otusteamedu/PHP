<?php


namespace App;


class Type
{
    private $id;
    private $nameType;
    public function  getId(){
        return $this->id;

    }
    public function  setId($id){
        $this->id=$id;
    }

    public function  getName_type(){
        return $this->nameType;
    }
    public function  setNameType($nameType){
        $this->nameType= $nameType;
    }
    public function  __construct($id,$nameType)
    {
        $this->id=$id;
        $this->nameType=$nameType;
    }

}