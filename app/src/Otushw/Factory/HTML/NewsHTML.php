<?php


namespace Otushw\Factory\HTML;

use Otushw\Models\News;
use Otushw\DTOs\NewsDTO;

/**
 * Class NewsHTML
 *
 * @package Otushw\Factory\HTML
 */
class NewsHTML extends News
{

    /**
     * NewsHTML constructor.
     *
     * @param NewsDTO $raw
     */
    public function __construct(NewsDTO $raw)
    {
        $this->setTitle($raw->title);
        $this->setBody($raw->body);
        $this->setCreated($raw->created);
        $this->setEvent($raw->event);
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return '<div class="title">' . $this->title . '</div>';
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return '<div class="body">' . $this->body . '</div>';
    }

    /**
     * @return string
     */
    public function getCreated(): string
    {
        return '<div class="created">' . $this->created . '</div>';
    }

    /**
     * @return string
     */
    public function getEvent(): string
    {
        return '<div class="event">' . $this->event . '</div>';
    }

    /**
     * @param string $event
     */
    public function setEvent(string $event): void
    {
        $this->event = $this->wrapperProperty($event);
    }

}
