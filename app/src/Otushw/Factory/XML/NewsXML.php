<?php


namespace Otushw\Factory\XML;

use Otushw\Models\News;
use Otushw\DTOs\NewsDTO;

/**
 * Class NewsXML
 *
 * @package Otushw\Factory\XML
 */
class NewsXML extends News
{

    /**
     * NewsXML constructor.
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
        return '<title>' . $this->title . '</title>';
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return '<body>' . $this->body . '</body>';
    }

    /**
     * @return string
     */
    public function getCreated(): string
    {
        return '<created>' . $this->created . '</created>';
    }

    /**
     * @return string
     */
    public function getEvent(): string
    {
        return '<event>' . $this->event . '</event>';
    }

    /**
     * @param string $event
     */
    public function setEvent(string $event): void
    {
        $this->event = $this->wrapperProperty($event);
    }

}