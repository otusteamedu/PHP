<?php


namespace Otus\AbstractFactory\Factory;


use Otus\AbstractFactory\Interfaces\ArticleFactory;
use Otus\AbstractFactory\Interfaces\News;
use Otus\AbstractFactory\Interfaces\Review;
use Otus\AbstractFactory\JsonNews;
use Otus\AbstractFactory\JsonReview;

class JsonFactory implements ArticleFactory
{

    public function createNews(): News
    {
        return new JsonNews();
    }

    public function createReview(): Review
    {
        return new JsonReview();
    }
}