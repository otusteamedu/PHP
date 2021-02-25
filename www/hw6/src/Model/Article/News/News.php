<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Article\News;

use Nlazarev\Hw6\Model\Article\Article;
use Nlazarev\Hw6\Model\Article\IArticleVisitor;

class News extends Article implements INews
{
    private string $source;

    public function __construct(string $header, string $main_text, string $source)
    {
        $this->setHeader($header)
            ->setMainText($main_text)
            ->setSource($source);
    }

    public function getSource(): string
    {
        return $this->source;
    }

    public function setSource(string $source)
    {
        $this->source = $source;

        return $this;
    }

    public function accept(IArticleVisitor $visitor)
    {
        $visitor->visitNews($this);
    }

}