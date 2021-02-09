<?php


namespace Otushw\Observer;

use Otushw\Article;
use Otushw\Message;

class MessageObserver implements ObserverInterface
{
    /**
     * @param Article $article
     */
    public function update(Article $article): void
    {
        Message::showMessage('Observer see: Fabric generated Article: ' . $article->getTitleWithoutFormat());
    }
}