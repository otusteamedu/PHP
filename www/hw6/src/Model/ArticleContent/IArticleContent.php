<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\ArticleContent;

use Nlazarev\Hw6\Model\Wrapper\WrapperArticle\IWrapperArticle;

interface IArticleContent
{
    public function getWrapper(): IWrapperArticle;
    public function setWrapper(IWrapperArticle $wrapper);
    public function getContent();
    public function accept(IArticleVisitor $visitor);
}
