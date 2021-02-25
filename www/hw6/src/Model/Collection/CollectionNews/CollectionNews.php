<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Collection\CollectionNews;

use Nlazarev\Hw6\Model\Article\IArticle;
use Nlazarev\Hw6\Model\Article\IArticleVisitor;
use Nlazarev\Hw6\Model\Article\News\INews;
use Nlazarev\Hw6\Model\Article\Review\IReview;
use Nlazarev\Hw6\Model\Collection\CollectionArticle\ICollectionArticle;
use SplSubject;

class CollectionNews implements ICollectionNews, IArticleVisitor
{
    private array $news;

    public function __construct(INews ...$news)
    {
        $this->news = $news;
    }

    public function add(INews $news)
    {
        $this->news[] = $news;

        return $this;
    }

    public function toArray(): array
    {
        return $this->news;
    }

    public function update(SplSubject $collection_article, $event = null, $data = null): void
    {
        if (!($collection_article instanceof ICollectionArticle)) {
            return;
        }

        if (($event !== ICollectionArticle::EVENTS_ARTICLE_ADD) &&
            ($event !== ICollectionArticle::EVENTS_ALL)
        ) {
            return;
        }

        if (!($data instanceof IArticle)) {
            return;
        }

        $data->accept($this);
    }

    public function visitNews(INews $news): void
    {
        $this->add($news);
    }

    public function visitReview(IReview $review): void
    {
        return;
    }
}
