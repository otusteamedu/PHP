<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\ArticleFactory;

use Nlazarev\Hw6\Model\ArticleContent\NewsContent\INewsContent;
use Nlazarev\Hw6\Model\ArticleContent\ReviewContent\IReviewContent;

interface IArticleFactory
{
    public static function getInstance(): IArticleFactory;
    public function createNewsContent(string $header = "", string $main_text = "", string $source = ""): INewsContent;
    public function createReviewContent(string $header = "", string $main_text = "", int $rating = 1): IReviewContent;
}
