<?php


namespace Repetitor202\Observer\ArticleObserver;


use Repetitor202\Factory\Article;


class EchoArticleObserver implements IArticleObserver
{
    public function update(Article $article): void
    {
        echo 'Was added Article: ' . $article->getTitle() . '</br>';
    }
}