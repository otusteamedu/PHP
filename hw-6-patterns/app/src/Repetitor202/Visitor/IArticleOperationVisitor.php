<?php


namespace Repetitor202\Visitor;

use Repetitor202\Factory\News;
use Repetitor202\Factory\Review;

interface IArticleOperationVisitor
{
    public function visitNews(News $news): void;
    public function visitReview(Review $review): void;
}