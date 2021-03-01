<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\ArticleContent;

use Nlazarev\Hw6\Model\ArticleContent\NewsContent\INewsContent;
use Nlazarev\Hw6\Model\ArticleContent\ReviewContent\IReviewContent;

interface IArticleVisitor
{
    public function visitNews(INewsContent $news): void;
    public function visitReview(IReviewContent $review): void;
}
