<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\ArticleFactory;

use Nlazarev\Hw6\Model\Article\News\INews;
use Nlazarev\Hw6\Model\Article\Review\IReview;

interface IArticleFactory
{
    public static function getInstance(): IArticleFactory;
    public function createNews(string $header = "", string $main_text = "", string $source = ""): INews;
    public function createReview(string $header = "", string $main_text = "", int $rating = 1): IReview;
}
