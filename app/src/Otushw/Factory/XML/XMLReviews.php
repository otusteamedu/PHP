<?php


namespace Otushw\Factory\XML;

use Otushw\DTOs\ReviewsDTO;
use Otushw\Factory\Render;
use Otushw\Factory\Reviews;

class XMLReviews extends Reviews
{

    private string $title;
    private string $body;
    private string $nameProduct;
    private int $created;
    private Render $render;

    public function __construct(ReviewsDTO $raw)
    {
        $this->title = $raw->title;
        $this->body = $raw->body;
        $this->nameProduct = $raw->nameProduct;
        $this->created = $raw->created;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function getCreated(): int
    {
        return $this->created;
    }

    public function setCreated(int $created): void
    {
        $this->created = $created;
    }


    public function getNameProduct(): string
    {
        return $this->nameProduct;
    }


    public function setNameProduct(string $nameProduct): void
    {
        $this->nameProduct = $nameProduct;
    }


    public function setRender(Render $render): void
    {
        $this->render = $render;
    }

    public function render(): void
    {
        $this->render->render($this);
    }

}