<?php


namespace Otushw\Models;

use Otushw\Article;
use Otushw\DTOs\ReviewsDTO;
use Otushw\Visitor\Entity;
use Otushw\Visitor\Visitor;

class Reviews extends Article implements Entity
{
    protected string $nameProduct;

    public function __construct(ReviewsDTO $raw)
    {
        $this->setTitle($raw->title);
        $this->setBody($raw->body);
        $this->setCreated($raw->created);
        $this->setNameProduct($raw->nameProduct);
    }

    public function getNameProduct(): string
    {
        return $this->nameProduct;
    }

    public function setNameProduct(string $nameProduct): void
    {
        $this->nameProduct = $nameProduct;
    }

    public function accept(Visitor $visitor): void
    {
        $visitor->visitReviews($this);
    }

}
