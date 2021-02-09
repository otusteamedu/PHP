<?php


namespace Otushw\Factory\HTML;

use Otushw\Models\Reviews;
use Otushw\DTOs\ReviewsDTO;

/**
 * Class ReviewsHTML
 *
 * @package Otushw\Factory\HTML
 */
class ReviewsHTML extends Reviews
{

    /**
     * ReviewsHTML constructor.
     *
     * @param ReviewsDTO $raw
     */
    public function __construct(ReviewsDTO $raw)
    {
        $this->setTitle($raw->title);
        $this->setBody($raw->body);
        $this->setCreated($raw->created);
        $this->setNameProduct($raw->nameProduct);
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return '<div class="title">' . $this->title . '</div>';
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return '<div class="body">' . $this->bod . '</div>';
    }

    /**
     * @return string
     */
    public function getCreated(): string
    {
        return '<div class="created">' . $this->created . '</div>';
    }

    /**
     * @return string
     */
    public function getNameProduct(): string
    {
        return '<div class="name-product">' . $this->nameProduct . '</div>';
    }

    /**
     * @param string $nameProduct
     */
    public function setNameProduct(string $nameProduct): void
    {
        $this->$nameProduct = $this->wrapperProperty($nameProduct);
    }

}
