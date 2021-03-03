<?php

declare(strict_types=1);

namespace Nlazarev\Hw6;

use Nlazarev\Hw6\Model\ArticleFactory\ArticleFactoryHtml\ArticleFactoryHtml;
use Nlazarev\Hw6\Model\Articles;

final class App
{
    public static function run()
    {
        $articles = new Articles(ArticleFactoryHtml::getInstance());

        $articles->createNews()
            ->createReview();
    }
}
