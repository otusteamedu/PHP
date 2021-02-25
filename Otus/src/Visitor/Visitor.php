<?php


namespace Otus\Visitor;


use Otus\AbstractFactory\Interfaces\News;
use Otus\AbstractFactory\Interfaces\Review;

class SomeAction implements ArticleVisitor
{
    public function visitReview(Review $review)
    {
        echo 'Review visited' . PHP_EOL;
    }

    public function visitNews(News $news)
    {
        echo 'news visited' . PHP_EOL;
    }
}