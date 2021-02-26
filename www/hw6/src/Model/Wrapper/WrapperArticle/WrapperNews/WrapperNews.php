<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Wrapper\WrapperArticle\WrapperNews;

use Nlazarev\Hw6\Model\Article\News\INews;
use Nlazarev\Hw6\Model\Wrapper\WrapperArticle\IWrapperArticle;

abstract class WrapperNews implements IWrapperArticle
{
    private INews $news;

    public function __construct(INews $news)
    {
        $this->news = $news;
    }

    public function getNews()
    {
        return $this->news;
    }

    public function setNews($news)
    {
        $this->news = $news;

        return $this;
    }

    abstract public function build();
}
