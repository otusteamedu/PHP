<?php
namespace Otus\Visitor;

use Otus\AbstractFactory\Interfaces\News;
use Otus\AbstractFactory\Interfaces\Review;

interface ArticleVisitor
{
    public function visitReview(Review $review);
    public function visitNews(News $news);
}