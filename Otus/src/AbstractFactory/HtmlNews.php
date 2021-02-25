<?php


namespace Otus\AbstractFactory;


use Otus\AbstractFactory\Interfaces\News;
use Otus\Visitor\ArticleVisitor;

class HtmlNews implements News
{
    public function getNews()
    {
        echo 'html news';
    }

    public function accept(ArticleVisitor $visitor)
    {
        $visitor->visitNews($this);
    }
}