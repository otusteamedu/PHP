<?php

namespace discounts;

interface IDiscount
{
    public function calc(&$obj);
}