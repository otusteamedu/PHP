<?php

namespace Classes\Repositories;

use Classes\Models\Discount;

class DiscountRepositoryInterfaceImpl implements DiscountRepositoryInterface
{

    private $dbClient;

    public function __construct($dbClient)
    {
        $this->dbClient = $dbClient;
    }

    public function getAllDiscounts(): array
    {
        // TODO: Implement getAllDiscounts() method.
    }

    public function getDiscountById(int $id) : Discount
    {
        // TODO: Implement getDiscountById() method.
    }

    public function getDiscountByName(string $name): Discount
    {
        // TODO: Implement getDiscountByName() method.
    }

    public function getDiscountByType(int $type): Discount
    {
        // TODO: Implement getDiscountByType() method.
    }

    public function getDiscountWithMaxValue(): Discount
    {
        // TODO: Implement getDiscountWithMaxValue() method.
    }
}
