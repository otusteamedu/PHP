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
    abstract public function getTitle(): string;

    public function getTitleWithoutFormat(): string
    {
        return $this->title;
    }

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
    abstract public function getBody(): string;

    /**
     * @param string $body
     */
    protected function setBody(string $body): void
    {
        $this->body = $this->wrapperProperty($body);
    }

    /**
     * @return string
     */
    abstract public function getCreated(): string;

    /**
     * @param int $created
     */
    public function setCreated(int $created): void
    {
        $this->created = $created;
    }

    /**
     * @param string $value
     *
     * @return string
     */
    protected function wrapperProperty(string $value): string
    {
        return get_class($this) . ': ' . $value;
    }
}