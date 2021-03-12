<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Collection\CollectionArticle;

use Nlazarev\Hw6\Model\ArticleContent\IArticleContent;
use Nlazarev\Hw6\Model\Collection\CollectionObserver\CollectionObserver;
use Nlazarev\Hw6\Model\Collection\CollectionObserver\ICollectionObserver;
use Nlazarev\Hw6\Model\Iterator\IIteratorCustom;
use Nlazarev\Hw6\Model\Iterator\IteratorArticle\IteratorArticle;
use SplObserver;

class CollectionArticle implements ICollectionArticle
{
    private array $articles;
    private ICollectionObserver $observers;

    public function __construct(IArticleContent ...$articles)
    {
        $this->articles = $articles;
        $this->observers = new CollectionObserver(self::EVENTS_ALL, self::EVENTS_ARTICLE_ADD);
    }

    public function getObservers(): ICollectionObserver
    {
        return $this->observers;
    }

    public function attach(SplObserver $observer, $event = self::EVENTS_ALL): void
    {
        if (in_array($event, $this->observers->getEvents())) {
            $this->observers->add($observer, $event);
        } else {
            throw new \Exception("'$event' There's no such event in publisher-class");
        }
    }

    public function detach(SplObserver $observer, $event = self::EVENTS_ALL): void
    {
        $this->observers->rem($observer, $event);
    }

    public function notify($event = self::EVENTS_ALL, $data = null): void
    {
        foreach ($this->observers->getIterator() as $observer) {
            $observer->update($this, self::EVENTS_ALL, $data);
        }

        if ($event != self::EVENTS_ALL) {
            foreach ($this->observers->getIterator($event) as $observer) {
                $observer->update($this, $event, $data);
            }
        }
    }

    public function add(IArticleContent $article)
    {
        $this->articles[] = $article;
        $this->notify(self::EVENTS_ARTICLE_ADD, $article);

        return $this;
    }

    public function toArray(): array
    {
        return $this->articles;
    }

    public function getIterator(): IIteratorCustom
    {
        return new IteratorArticle($this);
    }
}
