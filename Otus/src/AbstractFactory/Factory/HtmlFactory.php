<?php


namespace Otus\AbstractFactory\Factory;


use Otus\AbstractFactory\HtmlNews;
use Otus\AbstractFactory\HtmlReview;
use Otus\AbstractFactory\Interfaces\ArticleFactory;
use Otus\AbstractFactory\Interfaces\News;
use Otus\AbstractFactory\Interfaces\Review;

class HtmlFactory implements ArticleFactory
{

    public function createNews(): News
    {
        return new HtmlNews();
    }

    public function createReview(): Review
    {
        return new HtmlReview();
    }
}