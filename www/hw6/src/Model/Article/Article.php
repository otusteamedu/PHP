<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Article;

use Nlazarev\Hw6\Model\Wrapper\WrapperArticle\IWrapperArticle;

abstract class Article implements IArticle
{
    private string $header;
    private string $main_text;
    private IWrapperArticle $wrapper;

    public function setWrapper(IWrapperArticle $wrapper)
    {
        $this->wrapper = $wrapper;

        return $this;
    }

    public function getContent()
    {
        if (isset($this->wrapper)) {
            return $this->wrapper->build();
        }

        throw new \Exception("Wrapper for build content isn't set");
    }

    public function getHeader(): string
    {
        return $this->header;
    }

    public function setHeader(string $header)
    {
        $this->header = $header;

        return $this;
    }

    public function getMainText(): string
    {
        return $this->main_text;
    }

    public function setMainText(string $main_text)
    {
        $this->main_text = $main_text;

        return $this;
    }

    abstract public function accept(IArticleVisitor $visitor);
}
