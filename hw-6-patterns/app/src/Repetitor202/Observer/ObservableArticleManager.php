<?php


namespace Repetitor202\Observer;


use Repetitor202\Factory\Article;
use Repetitor202\Observer\ArticleObserver\IArticleObserver;

class ObservableArticleManager
{
    private array $observers = [];

    public function attach(IArticleObserver $observer): void
    {
        $this->observers[] = $observer;
    }

    public function detach(IArticleObserver $observer): void
    {
        foreach ($this->observers as &$search) {
            if ($search === $observer) {
                unset($search);
            }
        }
    }

    public function notify(Article $article): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($article);
        }
    }

}