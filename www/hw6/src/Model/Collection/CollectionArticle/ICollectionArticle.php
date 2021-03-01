<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Collection\CollectionArticle;

use IteratorAggregate;
use Nlazarev\Hw6\Model\ArticleContent\IArticleContent;
use Nlazarev\Hw6\Model\Storage\StoragePublisher\IPublisherWithEvents;

interface ICollectionArticle extends IPublisherWithEvents, IteratorAggregate
{
    public const EVENTS_ARTICLE_ADD = "article:add";
    public function add(IArticleContent $article);
    public function toArray(): array;
}
