<?php

declare(strict_types=1);

namespace Nlazarev\Hw6;

use Nlazarev\Hw6\Model\ArticleFactory\ArticleFactoryHtml\ArticleFactoryHtml;
use Nlazarev\Hw6\Model\ArticleFactory\ArticleFactoryJson\ArticleFactoryJson;
use Nlazarev\Hw6\Model\ArticleFactory\ArticleFactoryXml\ArticleFactoryXml;
use Nlazarev\Hw6\Model\ArticleFactory\IArticleFactory;
use Nlazarev\Hw6\Model\Collection\CollectionArticle\CollectionArticle;
use Nlazarev\Hw6\Model\Collection\CollectionArticle\ICollectionArticle;
use Nlazarev\Hw6\Model\Collection\CollectionNews\CollectionNews;
use Nlazarev\Hw6\Model\Collection\CollectionNews\ICollectionNews;
use Nlazarev\Hw6\Model\Storage\StoragePublisher\IStoragePublisher;
use Nlazarev\Hw6\Model\Storage\StoragePublisher\StoragePublisher;

final class App
{
    private static ICollectionArticle $articles;
    private static ICollectionNews $news;
    private static IStoragePublisher $storage_publisher;

    public static function run()
    {
        static::$storage_publisher = StoragePublisher::getInstance();

        static::$articles = new CollectionArticle();
        static::$news = new CollectionNews();

        try {
            $event = static::$articles::EVENTS_ARTICLE_ADD;
            static::$articles->attach(static::$news, $event);
        } catch (\Exception $e) {
            echo $e->getMessage();
            echo "<br>";
        }

        $articles2 = new CollectionArticle();
        $news2 = new CollectionNews();
        static::$storage_publisher->attach(static::$articles);
        static::$storage_publisher->attach($articles2);
        static::$storage_publisher->getObservers($articles2)->add($news2, $articles2::EVENTS_ALL);

        static::generateArticles(static::$articles, ArticleFactoryHtml::getInstance());
        static::generateArticles($articles2, ArticleFactoryXml::getInstance());
        static::generateArticles(static::$articles, ArticleFactoryJson::getInstance());


        //Some results
        echo "<br>";
        echo "[NewsCollection1]";
        echo "<br>";
        echo "total: " . count(static::$news->toArray());
        echo "<br>";

        echo "<br>";
        echo "[NewsCollection2]";
        echo "<br>";
        echo "total: " . count($news2->toArray());
        echo "<br>";

        echo "<br>";
        echo "Publisher-objects in storage: " . static::$storage_publisher->count();
        echo "<br>";
        echo "<br>";

        foreach (static::$storage_publisher->getPublishers()->toArray() as $publisher) {
            echo serialize($publisher);
            echo "<br>";

            foreach (static::$storage_publisher->getObservers($publisher)->toArray() as $key => $observers) {
                echo "[$key]" . "<br>";
                echo serialize($observers);
                echo "<br>";
            }

            echo "<br>";
            echo "<br>";
        }
    }

    private static function generateArticles(ICollectionArticle $articles, IArticleFactory $articles_factory)
    {
        $articles->add($articles_factory->createNews());
        $articles->add($articles_factory->createNews());
        $articles->add($articles_factory->createReview());
        $articles->add($articles_factory->createNews());
        $articles->add($articles_factory->createReview());
        $articles->add($articles_factory->createNews());
    }
}
