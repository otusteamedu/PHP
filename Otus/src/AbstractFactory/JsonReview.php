<?php
namespace Otus\AbstractFactory;


use Otus\AbstractFactory\Interfaces\Review;
use Otus\Visitor\ArticleVisitor;

class JsonReview implements Review
{

    public function getReview()
    {
        // TODO: Implement getReview() method.
    }

    public function accept(ArticleVisitor $visitor)
    {
        $visitor->visitReview($this);
    }
}