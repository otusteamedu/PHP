<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Collection\CollectionNews;

use Nlazarev\Hw6\Model\ArticleContent\IArticleContent;
use Nlazarev\Hw6\Model\ArticleContent\IArticleVisitor;
use Nlazarev\Hw6\Model\ArticleContent\NewsContent\INewsContent;
use Nlazarev\Hw6\Model\ArticleContent\ReviewContent\IReviewContent;
use Nlazarev\Hw6\Model\Collection\CollectionArticle\ICollectionArticle;
use SplSubject;

class CollectionNews implements ICollectionNews, IArticleVisitor
{
    private array $news;

    public function __construct(INewsContent ...$news)
    {
        $this->news = $news;
    }

    public function add(INewsContent $news)
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

        if (!($data instanceof IArticleContent)) {
            return;
        }

        $data->accept($this);
    }

    public function visitNews(INewsContent $news): void
    {
        $this->add($news);
    }

    public function visitReview(IReviewContent $review): void
    {
        return;
    }
}
