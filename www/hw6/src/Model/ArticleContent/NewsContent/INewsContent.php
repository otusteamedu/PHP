<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\ArticleContent\NewsContent;

use Nlazarev\Hw6\Model\ArticleContent\IArticleContent;
use Nlazarev\Hw6\Model\Article\News\INews;

interface INewsContent extends IArticleContent
{
    public function getNews(): INews;
    public function setNews(INews $news);
}
