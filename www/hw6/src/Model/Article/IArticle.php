<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Article;

interface IArticle
{
    public function getHeader(): string;
    public function setHeader(string $header);
    public function getMainText(): string;
    public function setMainText(string $main_text);
}
