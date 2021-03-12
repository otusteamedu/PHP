<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\ArticleContent\NewsContent;

use Nlazarev\Hw6\Model\ArticleContent\ArticleContent;
use Nlazarev\Hw6\Model\ArticleContent\IArticleVisitor;
use Nlazarev\Hw6\Model\Article\News\INews;
use Nlazarev\Hw6\Model\Wrapper\WrapperArticle\IWrapperArticle;

class NewsContent extends ArticleContent implements INewsContent
{
    private INews $news;

    public function __construct(INews $news, IWrapperArticle $wrapper)
    {
        $this->news = $news;
        $this->setWrapper($wrapper);
    }

    public function getNews(): INews
    {
        return $this->news;
    }

    public function setNews(INews $news)
    {
        $this->news = $news;

        return $this;
    }

    public function accept(IArticleVisitor $visitor)
    {
        $visitor->visitNews($this);
    }
}
