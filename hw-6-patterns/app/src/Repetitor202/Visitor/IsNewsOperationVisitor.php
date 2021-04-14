<?php


namespace Repetitor202\Visitor;

use Repetitor202\Factory\News;
use Repetitor202\Factory\Review;

class IsNewsOperationVisitor implements IArticleOperationVisitor
{

    public function visitNews(News $news): void
    {
        $news->isNewsAcceptedByVisitor = true;
    }

    public function visitReview(Review $review): void
    {
        $review->isNewsAcceptedByVisitor = false;
    }
}