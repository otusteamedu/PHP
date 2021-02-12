<?php


namespace Otushw\DTOs;

class ReviewsDTO
{
    public string $title;

    public string $body;

    public int $created;

    public string $nameProduct;

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