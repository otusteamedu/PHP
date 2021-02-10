<?php


namespace Otushw\Factory\XML;

use Otushw\Factory\ArticleFactory;
use Otushw\Factory\Render;
use Otushw\Models\News;
use Otushw\Models\Reviews;
use Otushw\DTOs\NewsDTO;
use Otushw\DTOs\ReviewsDTO;

class XMLArticleFactory extends ArticleFactory
{
    const FORMAT = 'XML';

    public function createNews(NewsDTO $raw): News
    {
        $news = new XMLNews($raw);
        $this->notify($news);

        return $news;
    }

    public function createReviews(ReviewsDTO $raw): Reviews
    {
        $review = new XMLReviews($raw);
        $this->notify($review);

        return $review;
    }

    public function renderNews(News $news): void
    {
        $render = new Render(self::FORMAT, 'news');
        $render->render($news);
    }

    public function renderReviews(Reviews $reviews): void
    {
        $render = new Render(self::FORMAT, 'reviews');
        $render->render($reviews);
    }

}