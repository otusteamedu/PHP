<?php


namespace Otus\AbstractFactory;


use Otus\AbstractFactory\Interfaces\News;
use Otus\Visitor\ArticleVisitor;

class JsonNews implements News
{
    public function getNews()
    {
        echo 'json news' . PHP_EOL;
    }

    public function accept(ArticleVisitor $visitor)
    {
        $visitor->visitNews($this);
    }
}