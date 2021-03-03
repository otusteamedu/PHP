<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model;

use Nlazarev\Hw6\Model\ArticleContent\NewsContent\INewsContent;
use Nlazarev\Hw6\Model\ArticleFactory\IArticleFactory;
use Nlazarev\Hw6\Model\Collection\CollectionArticle\CollectionArticle;
use Nlazarev\Hw6\Model\Collection\CollectionArticle\ICollectionArticle;
use Nlazarev\Hw6\Model\Collection\CollectionNews\CollectionNews;
use Nlazarev\Hw6\Model\Collection\CollectionNews\ICollectionNews;
use Nlazarev\Hw6\Model\External\News\NewsExternal;
use Nlazarev\Hw6\Model\External\News\NewsToNewsExternal;
use Nlazarev\Hw6\Model\Storage\StoragePublisher\StoragePublisher;

class Articles
{
    private IArticleFactory $articles_factory;
    private ICollectionArticle $articles;
    private ICollectionNews $news;
    private NewsExternal $exporteApi;

    public function __construct(IArticleFactory $articles_factory)
    {
        $this->articles_factory = $articles_factory;
        $this->articles = new CollectionArticle();
        $this->news = new CollectionNews();
        $this->exporteApi = new NewsExternal();

        $event = $this->articles::EVENTS_ARTICLE_ADD;
        $this->articles->attach($this->news, $event);

        StoragePublisher::getInstance()->attach($this->articles);
    }

    public function createNews()
    {
        $this->articles->add($this->articles_factory->createNewsContent());

        return $this;
    }

    public function createReview()
    {
        $this->articles->add($this->articles_factory->createReviewContent());

        return $this;
    }

    public function getCollectionNews(): ICollectionNews
    {
        return $this->news;
    }

    public function exportNews($dest)
    {
        foreach ($this->news->toArray() as $news) {
            $adapter = new NewsToNewsExternal($news->getNews(), $this->exporteApi, $dest);
            $this->exportThisNews($adapter);
        }
    }

    private static function exportThisNews(INewsContent $news)
    {
        return $news->getContent();
    }
}
