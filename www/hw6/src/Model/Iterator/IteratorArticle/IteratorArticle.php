<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Iterator\IteratorArticle;

use Nlazarev\Hw6\Model\ArticleContent\IArticleContent;
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

    public function current(): IArticleContent
    {
        return $this->articles[$this->key()];
    }

    public function valid(): bool
    {
        return isset($this->articles[$this->key()]);
    }
}
