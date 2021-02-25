<?php
namespace Otus\Proxy;

use Otus\AbstractFactory\Interfaces\News;
use Otus\Visitor\ArticleVisitor;

class JsonNewsProxy implements News
{
    public function getNews()
    {
       $cachedNews = $this->getChachedNews();

       if (!empty($cachedNews)) {
           echo 'cached news' . PHP_EOL;
       }

       echo 'not cached news' . PHP_EOL;
    }

    public function accept(ArticleVisitor $visitor)
    {
        $visitor->visitNews($this);
    }

    private function getChachedNews()
    {
        return [];
    }
}