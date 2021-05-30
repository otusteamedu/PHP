<?php
namespace Src\AbstractFactory;

interface AbstractFoodFactory
{
    public function cookFood(): AbstractFoodInterface;
}
