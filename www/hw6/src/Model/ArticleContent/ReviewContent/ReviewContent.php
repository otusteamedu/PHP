<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\ArticleContent\ReviewContent;

use Nlazarev\Hw6\Model\ArticleContent\ArticleContent;
use Nlazarev\Hw6\Model\ArticleContent\IArticleVisitor;
use Nlazarev\Hw6\Model\Article\Review\IReview;
use Nlazarev\Hw6\Model\Wrapper\WrapperArticle\IWrapperArticle;

class ReviewContent extends ArticleContent implements IReviewContent
{
    private IReview $review;

    public function __construct(IReview $review, IWrapperArticle $wrapper)
    {
        $this->review = $review;
        $this->setWrapper($wrapper);
    }

    public function getReview(): IReview
    {
        return $this->review;
    }

    public function setReview(IReview $review)
    {
        $this->review = $review;

        return $this;
    }

    public function accept(IArticleVisitor $visitor)
    {
        $visitor->visitReview($this);
    }
}
