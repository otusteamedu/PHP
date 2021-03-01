<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Collection\CollectionNews;

use Nlazarev\Hw6\Model\ArticleContent\NewsContent\INewsContent;
use SplObserver;

interface ICollectionNews extends SplObserver
{
    public function add(INewsContent $news);
    public function toArray(): array;
}
