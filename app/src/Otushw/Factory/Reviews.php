<?php


namespace Otushw\Factory;

use Otushw\Visitor\Visitor;

abstract class Reviews implements Article
{
    public function accept(Visitor $visitor): void
    {
        $visitor->visitReviews($this);
    }

    abstract public function getNameProduct(): string;
    abstract public function setNameProduct(string $nameProduct): void;
}
