<?php


namespace App;


interface FinalPriceInterface
{
    public function findByPriceId(int $id);
}