<?php
namespace Src\Strategy;

interface Strategy
{
    public function chooseDishesToCook(string $order);
}