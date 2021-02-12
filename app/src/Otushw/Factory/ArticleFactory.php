<?php


namespace Otushw\Factory;

use Otushw\DTOs\NewsDTO;
use Otushw\DTOs\ReviewsDTO;

abstract class ArticleFactory
{
    abstract public function createNews(NewsDTO $raw): News;

    abstract public function createReviews(ReviewsDTO $raw): Reviews;

    abstract public function getRender(string $typeTemplate): Render;
}
