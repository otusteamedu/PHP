<?php


namespace Otus\Adapter;


use Otus\AbstractFactory\Interfaces\News;
use Otus\Visitor\ArticleVisitor;

class NewsAdapter implements News
{
    private DifferentTypeNews $differentTypeNews;

    public function __construct(DifferentTypeNews $differentTypeNews)
    {
        $this->differentTypeNews = $differentTypeNews;
    }

    public function getNews()
    {
        $this->differentTypeNews->setSomeData();
        $this->differentTypeNews->getDifferentNews();
    }

    public function accept(ArticleVisitor $visitor)
    {
        $visitor->visitNews($this);
    }
}