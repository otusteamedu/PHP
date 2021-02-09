<?php


namespace Otushw\Factory\XML;

use Otushw\Models\Reviews;
use Otushw\DTOs\ReviewsDTO;

/**
 * Class ReviewsXML
 *
 * @package Otushw\Factory\XML
 */
class ReviewsXML extends Reviews
{

    /**
     * ReviewsXML constructor.
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
        return '<title>' . $this->title . '</title>';
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return '<body>' . $this->body . '</body>';
    }

    /**
     * @return string
     */
    public function getCreated(): string
    {
        return '<created>' . $this->created . '</created>';
    }

    /**
     * @return string
     */
    public function getNameProduct(): string
    {
        return '<name-product>' . $this->nameProduct . '</name-product>';
    }

    /**
     * @param string $nameProduct
     */
    public function setNameProduct(string $nameProduct): void
    {
        $this->$nameProduct = $this->wrapperProperty($nameProduct);
    }
}