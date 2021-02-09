<?php


namespace Otushw\Adapter;

use Otushw\Exception\AppException;
use Otushw\Models\News;

/**
 * Class NewsHTMLAdapter
 *
 * @package Otushw\Adapter
 */
class NewsHTMLAdapter implements NewsHTMLInterface
{
    const REGEX_PATTERN = '/<[a-z]+[^>]*?>(.*?)<\/[a-z]+>/si';

    /**
     * @var News
     */
    private News $anyNews;

    /**
     * NewsHTMLAdapter constructor.
     *
     * @param News $news
     */
    public function __construct(News $news)
    {
        $this->anyNews = $news;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return '<div class="title">' . $this->convertProperty($this->anyNews->getTitle()) .  '</div>';
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return '<div class="body">' . $this->convertProperty($this->anyNews->getBody()) . '</div>';
    }

    /**
     * @return string
     */
    public function getCreated(): string
    {
        return '<div class="created">' . $this->convertProperty($this->anyNews->getCreated()) . '</div>';
    }

    /**
     * @return string
     */
    public function getEvent(): string
    {
        return '<div class="event">' . $this->convertProperty($this->anyNews->getEvent()) . '</div>';
    }

    /**
     * @param string $subject
     *
     * @return string
     * @throws AppException
     */
    private function convertProperty(string $subject): string
    {
        $result = preg_match(self::REGEX_PATTERN, $subject, $matches);
        if (empty($result) || empty($matches[1])) {
            throw new AppException('Regular expression cannot take value');
        }
        return $matches[1];
    }

}
