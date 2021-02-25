<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Collection\CollectionNews;

use Nlazarev\Hw6\Model\Article\News\INews;
use SplObserver;

interface ICollectionNews extends SplObserver
{
    public function add(INews $news);
    public function toArray(): array;
}
