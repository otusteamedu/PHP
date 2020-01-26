<?php


namespace App;


/**
 * Interface FactoryMethodInterface
 * @package App
 */
interface FactoryMethodInterface
{
    /**
     * @param int $id
     * @return mixed
     */
    public  function  findById(int $id);
}