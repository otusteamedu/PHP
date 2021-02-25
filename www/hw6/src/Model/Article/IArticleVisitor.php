<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Article;

use Nlazarev\Hw6\Model\Article\News\INews;
use Nlazarev\Hw6\Model\Article\Review\IReview;

interface IArticleVisitor
{
    public function visitNews(INews $news): void;
    public function visitReview(IReview $review): void;
}
