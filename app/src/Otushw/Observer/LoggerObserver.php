<?php


namespace Otushw\Observer;

use Otushw\Logger\AppLogger;
use Otushw\Article;

class LoggerObserver implements ObserverInterface
{
    /**
     * @param Article $article
     */
    public function update(Article $article): void
    {
        AppLogger::addInfo(
            'Was added Article: ' . get_class($article) . ': ' . $article->getTitleWithoutFormat()
        );
    }
}