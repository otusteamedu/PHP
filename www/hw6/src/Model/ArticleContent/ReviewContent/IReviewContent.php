<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\ArticleContent\ReviewContent;

use Nlazarev\Hw6\Model\ArticleContent\IArticleContent;
use Nlazarev\Hw6\Model\Article\Review\IReview;

interface IReviewContent extends IArticleContent
{
    public function getReview(): IReview;
    public function setReview(IReview $review);
}
