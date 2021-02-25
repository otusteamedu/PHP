<?php
namespace Otus\Proxy;

use Otus\ArticleService;

class ArticleProxy
{
    private ArticleService $article;

    public function __construct(ArticleService $article)
    {
        $this->article = $article;
    }

}