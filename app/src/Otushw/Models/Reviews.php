<?php


namespace Otushw\Models;

use Otushw\Article;
use Otushw\Visitor\Entity;
use Otushw\Visitor\Visitor;

/**
 * Class Reviews
 *
 * @package Otushw\Models
 */
abstract class Reviews extends Article implements Entity
{
    /**
     * @var string
     */
    protected string $nameProduct;

    /**
     * @return string
     */
    abstract public function getNameProduct(): string;

    /**
     * @param string $nameProduct
     */
    abstract public function setNameProduct(string $nameProduct): void;

    /**
     * @param Visitor $visitor
     *
     * @return void
     */
    public function accept(Visitor $visitor): void
    {
        $visitor->visitReviews($this);
    }

}