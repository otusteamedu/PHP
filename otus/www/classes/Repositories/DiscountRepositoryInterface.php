<?php

namespace Classes\Repositories;

use Classes\Models\Discount;

interface DiscountRepositoryInterface
{

    public function getAllDiscounts() : array;

    public function getDiscountById(int $id) : Discount;

    public function getDiscountByName(string $name) : Discount;

    public function getDiscountByType(int $type) : Discount;

    public function getDiscountWithMaxValue() : Discount;
}
