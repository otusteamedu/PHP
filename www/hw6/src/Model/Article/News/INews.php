<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Article\News;

use Nlazarev\Hw6\Model\Article\IArticle;

interface INews extends IArticle
{
    public function getSource(): string;
    public function setSource(string $source);
}
