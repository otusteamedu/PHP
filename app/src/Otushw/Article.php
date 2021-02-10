<?php


namespace Otushw;

abstract class Article
{

    protected string $title;

    protected string $body;

    protected int $created;

    protected string $format;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function getCreated(): string
    {
        return date('c', $this->created);
    }

    public function setCreated(int $created): void
    {
        $this->created = $created;
    }

}