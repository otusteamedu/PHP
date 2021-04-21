<?php

namespace Src\AbstractFactory;

interface FoodFactory
{
    public function cookFood() : AbstractFood;
}