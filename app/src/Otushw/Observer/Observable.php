<?php


namespace Otushw\Observer;

use Otushw\Factory\Article;

interface Observable
{
    public function attach(ObserverInterface $observer): void;

    public function detach(ObserverInterface $observer): void;

    public function notify(Article $article): void;
}
