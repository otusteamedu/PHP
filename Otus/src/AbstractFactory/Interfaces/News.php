<?php


namespace Otus\AbstractFactory\Interfaces;


use Otus\Visitor\ArticleVisitor;

interface News
{
    public function getNews();

    //visitor
    public function accept(ArticleVisitor $visitor);
}