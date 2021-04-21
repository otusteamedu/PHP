<?php


namespace Src\Strategy;


interface Strategy
{
    public function chooseMealToCook(string $order);
}