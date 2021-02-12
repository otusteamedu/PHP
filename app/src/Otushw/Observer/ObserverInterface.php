<?php


namespace Otushw\Observer;

use Otushw\Factory\Article;

interface ObserverInterface
{
    public function update(Article $article): void;
}