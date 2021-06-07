<?php


namespace App\Entities;


interface Entity
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * @param mixed $id
     * @return void
     */
    public function setId($id) : void;

    /**
     * @return array
     */
    public function toArray() : array;
}