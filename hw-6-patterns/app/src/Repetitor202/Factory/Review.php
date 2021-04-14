<?php


namespace Repetitor202\Factory;

use Repetitor202\Visitor\IArticleOperationVisitor;

abstract class Review extends Article
{
    public function accept(IArticleOperationVisitor $iArticleOperationVisitor): void
    {
        $iArticleOperationVisitor->visitReview($this);
    }
}
