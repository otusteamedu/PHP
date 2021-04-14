<?php


namespace Repetitor202\Factory;

use Repetitor202\Visitor\IArticleVisitable;

abstract class Article implements IArticleVisitable
{
    public const CATEGORY_NEWS = 'News';
    public const CATEGORY_REVIEW = 'Review';

    protected string $title;
    protected string $body;
    protected string $factoryBuild;

    public bool $isNewsAcceptedByVisitor = false;

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    abstract public function setFactoryBuild(): void;

    public function getFactoryBuild(): string
    {
        return $this->factoryBuild;
    }
}