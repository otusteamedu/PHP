<?php


namespace Otushw\Proxy;

use Otushw\Models\News;

/**
 * Class Proxy
 *
 * @package Otushw\Proxy
 */
class Proxy extends News
{
    /**
     * @var News
     */
    private News $news;

    /**
     * @var array
     */
    private array $cache;

    /**
     * Proxy constructor.
     *
     * @param News $news
     */
    public function __construct(News $news)
    {
        $this->news = $news;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        if (empty($this->cache['title'])) {
            $title = $this->news->getTitle();
            $this->cache['title'] = $title;
        } else {
            $title = 'I am from cache ' .  $this->cache['title'];
        }

        return $title;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        if (empty($this->cache['body'])) {
            $body = $this->news->getBody();
            $this->cache['title'] = $body;
        } else {
            $body = $this->wrapperCache($this->cache['body']);
        }

        return $body;
    }

    /**
     * @return string
     */
    public function getCreated(): string
    {
        if (empty($this->cache['created'])) {
            $created = $this->news->getCreated();
            $this->cache['created'] = $created;
        } else {
            $created = $this->wrapperCache($this->cache['created']);
        }

        return $created;
    }

    /**
     * @return string
     */
    public function getEvent(): string
    {
        if (empty($this->cache['event'])) {
            $event = $this->news->getEvent();
            $this->cache['event'] = $event;
        } else {
            $event = $this->wrapperCache($this->cache['event']);
        }

        return $event;
    }

    /**
     * @param string $event
     */
    public function setEvent(string $event): void
    {
        $this->event = $this->wrapperProperty($event);
    }

    /**
     * @param string $value
     *
     * @return string
     */
    private function wrapperCache(string $value): string
    {
        return 'I am from cache ' .  $value;
    }

}