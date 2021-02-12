<?php


namespace Otushw\Factory\XML;

use Otushw\DTOs\NewsDTO;
use Otushw\DTOs\ReviewsDTO;
use Otushw\Factory\ArticleFactory;
use Otushw\Factory\News;
use Otushw\Factory\Render;
use Otushw\Factory\Reviews;

class XMLArticleFactory extends ArticleFactory
{
    public function createNews(NewsDTO $raw): News
    {
        return new XMLNews($raw);
    }

    public function createReviews(ReviewsDTO $raw): Reviews
    {
        return new XMLReviews($raw);
    }

    public function getRender(string $typeTemplate): Render
    {
        return new XMLRender($typeTemplate);
    }
}
