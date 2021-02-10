<?php


namespace Otushw\Factory\HTML;

use Otushw\DTOs\NewsDTO;
use Otushw\DTOs\ReviewsDTO;
use Otushw\Factory\ArticleFactory;
use Otushw\Factory\Render;
use Otushw\Models\News;
use Otushw\Models\Reviews;

class HTMLArticleFactory extends ArticleFactory
{
    const FORMAT = 'HTML';

    public function createNews(NewsDTO $raw): News
    {
        $news = new HTMLNews($raw);
        $this->notify($news);
        return $news;
    }

    public function createReviews(ReviewsDTO $raw): Reviews
    {
        $reviews = new HTMLReviews($raw);
        $this->notify($reviews);
        return $reviews;
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
