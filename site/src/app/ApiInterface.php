<?php


namespace App;


/**
 * Interface ApiInterface
 * @package App
 */
interface ApiInterface
{
    /**
     * @param $raw
     * @return mixed
     */
    public function insert($raw);

    /**
     * @param $name
     * @return mixed
     */
    public function findByName($name);

    /**
     * @param Order $order
     * @return mixed
     */
    public function update(Order $order);

    /**
     * @param Order $order
     * @return mixed
     */
    public function delete(Order $order);
}