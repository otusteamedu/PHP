<?php


namespace App;


/**
 * Interface FinalPriceInterface
 * @package App
 */
interface FinalPriceInterface
{
    /**
     * @param int $id
     * @return mixed
     */
    public function findByPriceId(int $id);
}