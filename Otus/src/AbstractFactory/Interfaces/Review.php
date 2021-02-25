<?php


namespace Otus\AbstractFactory\Interfaces;


use Otus\Visitor\ArticleVisitor;

interface Review
{
    public function getReview();

    //visitor
    public function accept(ArticleVisitor $visitor);
}