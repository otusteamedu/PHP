<?php

use Otus\Adapter\DifferentTypeNews;
use Otus\Adapter\NewsAdapter;
use Otus\ArticleService;
use Otus\AbstractFactory\Factory\HtmlFactory;
use Otus\AbstractFactory\Factory\JsonFactory;
use Otus\Observer\SubscriberA;
use Otus\Observer\SubscriberB;
use Otus\Proxy\JsonNewsProxy;

require_once '../vendor/autoload.php';

try {
    $type = 'json';

    switch ($type) {
        case 'json':
            $factory = new JsonFactory();
            break;
        case 'html':
            $factory = new HtmlFactory();
            break;
        default:
            echo 'something wrong';
    }

    $article = new ArticleService($factory);

    $article->addObserver((new SubscriberA()));
    $article->addObserver((new SubscriberB()));

    $article->createNews();
    $article->getNews();

    //Adapter
    $differentNews = new DifferentTypeNews();
    $adaptedNews = new NewsAdapter($differentNews);
    $article->setNews($adaptedNews);
    $article->getNews();

    //proxy
    $article->setNews((new JsonNewsProxy()));
    $article->getNews();


}catch (\Exception $e) {
    echo $e->getMessage();
}
