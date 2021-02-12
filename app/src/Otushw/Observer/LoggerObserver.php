<?php


namespace Otushw\Observer;

use Otushw\Logger\AppLogger;
use Otushw\Factory\Article;

class LoggerObserver implements ObserverInterface
{
    public function update(Article $article): void
    {
        AppLogger::addInfo(
            'Was added Article: ' . $article->getTitle()
        );
    }
}