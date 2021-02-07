<?php


namespace Otushw;


/**
 * Class Article
 *
 * @package Otushw
 */
abstract class Article
{
    /**
     * @var string
     */
    protected string $title;

    /**
     * @var string
     */
    protected string $body;

    /**
     * @var int
     */
    protected int $created;

    /**
     * @return string
     */
    abstract protected function getTitle(): string;

    /**
     * @param string $title
     */
    protected function setTitle(string $title): void
    {
        $this->title = $this->wrapperProperty($title);
    }

    /**
     * @return string
     */
    abstract protected function getBody(): string;

    /**
     * @param string $body
     */
    protected function setBody(string $body): void
    {
        $this->body = $this->wrapperProperty($body);
    }

    /**
     * @return int
     */
    abstract protected function getCreated(): int;

    /**
     * @param int $created
     */
    protected function setCreated(int $created): void
    {
        $this->created = $this->wrapperProperty($created);
    }

    /**
     * @param string $value
     *
     * @return string
     */
    protected function wrapperProperty(string $value): string
    {
        return self::class . ': ' . $value;
    }
}