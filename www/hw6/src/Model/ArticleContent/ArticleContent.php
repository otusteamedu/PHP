<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\ArticleContent;

use Nlazarev\Hw6\Model\Wrapper\WrapperArticle\IWrapperArticle;

abstract class ArticleContent implements IArticleContent
{
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

    public function getWrapper(): IWrapperArticle
    {
        return $this->wrapper;
    }

    abstract public function accept(IArticleVisitor $visitor);
}
