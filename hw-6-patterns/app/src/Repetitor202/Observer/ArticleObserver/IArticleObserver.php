<?php


namespace Repetitor202\Observer\ArticleObserver;


use Repetitor202\Factory\Article;


interface IArticleObserver
{
    public function update(Article $article): void;
}