<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Controller;

use Laminas\Diactoros\Response;
use Nlazarev\Hw6\Model\ArticleFactory\ArticleFactoryHtml\ArticleFactoryHtml;
use Nlazarev\Hw6\Model\ArticleFactory\ArticleFactoryJson\ArticleFactoryJson;
use Nlazarev\Hw6\Model\ArticleFactory\IArticleFactory;
use Nlazarev\Hw6\Model\Collection\CollectionArticle\CollectionArticle;
use Nlazarev\Hw6\Model\Collection\CollectionArticle\ICollectionArticle;
use Nlazarev\Hw6\Model\Collection\CollectionNews\CollectionNews;
use Nlazarev\Hw6\Model\Collection\CollectionNews\ICollectionNews;
use Nlazarev\Hw6\Model\Storage\StoragePublisher\StoragePublisher;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Articles
{
    private IArticleFactory $articles_factory;
    private ICollectionArticle $articles;
    private ICollectionNews $news;

    public function __construct()
    {
        $this->articles = new CollectionArticle();
        $this->news = new CollectionNews();
        
        $event = $this->articles::EVENTS_ARTICLE_ADD;
        $this->articles->attach($this->news, $event);

        StoragePublisher::getInstance()->attach($this->articles);
    }

    public function addNews(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response;

        switch ($request->getUri()->getPath()) {
            case '/articles/news/add/html':
                $this->articles_factory = ArticleFactoryHtml::getInstance();
                break;
            case '/articles/news/add/xml':
                $this->articles_factory = ArticleFactoryXml::getInstance();
                break;
            case '/articles/news/add/json':
                $this->articles_factory = ArticleFactoryJson::getInstance();
                break;
            default:
                # code...
                break;
        }

        $this->articles->add($this->articles_factory->createNewsContent());
        return $response;
    }

    public function addReview(ServerRequestInterface $request): ResponseInterface
    {
        $response = new Response();

        switch ($request->getUri()->getPath()) {
            case '/articles/review/add/html':
                $this->articles_factory = ArticleFactoryHtml::getInstance();
                break;
            case '/articles/review/add/xml':
                $this->articles_factory = ArticleFactoryXml::getInstance();
                break;
            case '/articles/review/add/json':
                $this->articles_factory = ArticleFactoryJson::getInstance();
                break;
            default:
                # code...
                break;
        }

        $this->articles->add($this->articles_factory->createReviewContent());
        return $response;
    }
}
