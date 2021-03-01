<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Article;

abstract class Article implements IArticle
{
    private string $header;
    private string $main_text;

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
}
