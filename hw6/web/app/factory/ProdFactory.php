<?php

namespace factory;

use models\Product;

/**
 * Class ProdFactory
 * Фабрика товаров
 *
 * @package factory
 * @author  Petr Ivanov (petr.yrs@gmail.com)
 */
class ProdFactory
{
    const TYPES = [
        'apple',
        'orange',
        'banana',
    ];


    public function __construct($prodType)
    {
        switch ($prodType) {
            case 'apple':
                return $this->createApple();
            case 'orange':
                return $this->createOrange();
            case 'banana':
                return $this->createBanana();
            default:
                throw new Exception('Unknown product');
        }
    }


    /**
     * Apple
     *
     * @return Product
     */
    private function createApple()
    {
        $obj       = new Product();
        $obj->name = 'Apple';
        $obj->cost = 89.75;

        return $obj;
    }


    /**
     * Orange
     *
     * @return Product
     */
    private function createOrange()
    {
        $obj       = new Product();
        $obj->name = 'Orange';
        $obj->cost = 120.00;

        return $obj;
    }


    /**
     * Banana
     *
     * @return Product
     */
    private function createBanana()
    {
        $obj       = new Product();
        $obj->name = 'Banana';
        $obj->cost = 90;

        return $obj;
    }
}