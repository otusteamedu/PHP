<?php


namespace Otushw\Factory\HTML;

use Otushw\DTOs\NewsDTO;
use Otushw\DTOs\ReviewsDTO;
use Otushw\Factory\Render;
use Otushw\Factory\ArticleFactory;
use Otushw\Factory\News;
use Otushw\Factory\Reviews;

class HTMLArticleFactory extends ArticleFactory
{
    public function createNews(NewsDTO $raw): News
    {
        return new HTMLNews($raw);
    }

    public function createReviews(ReviewsDTO $raw): Reviews
    {
        return new HTMLReviews($raw);
    }

    public function getRender(string $typeTemplate): Render
    {
        return new HTMLRender($typeTemplate);
    }
}
