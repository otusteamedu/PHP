<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Iterator\IteratorArticle;

use Nlazarev\Hw6\Model\Article\IArticle;
use Nlazarev\Hw6\Model\Collection\CollectionArticle\CollectionArticle;
use Nlazarev\Hw6\Model\Collection\CollectionArticle\ICollectionArticle;
use Nlazarev\Hw6\Model\Iterator\IIteratorCustom;
use Nlazarev\Hw6\Model\Iterator\IteratorCustom;

class IteratorArticle extends IteratorCustom implements IIteratorCustom
{
    private $articles = [];

    public function __construct(ICollectionArticle $articles)
    {
        $this->articles = $articles->toArray();
    }

    public function current(): IArticle
    {
        return $this->articles[$this->key()];
    }

    public function valid(): bool
    {
        return isset($this->articles[$this->key()]);
    }

}
