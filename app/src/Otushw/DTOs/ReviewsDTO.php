<?php


namespace Otushw\DTOs;

/**
 * Class ReviewsDTO
 *
 * @package Otushw\DTOs
 */
class ReviewsDTO
{
    /**
     * @var string
     */
    public string $title;

    /**
     * @var string
     */
    public string $body;

    /**
     * @var int
     */
    public int $created;

    /**
     * @var string
     */
    public string $nameProduct;

    /**
     * ReviewsDTO constructor.
     *
     * @param string $title
     * @param string $body
     * @param int    $created
     * @param string $nameProduct
     */
    public function __construct(
        string $title,
        string $body,
        int $created,
        string $nameProduct
    ) {
        $this->title = $title;
        $this->body = $body;
        $this->created = $created;
        $this->nameProduct = $nameProduct;
    }
}