<?php


namespace Otushw\Factory\HTML;

use Otushw\Factory\ArticleFactory;
use Otushw\Models\News;
use Otushw\DTOs\NewsDTO;
use Otushw\Models\Reviews;
use Otushw\DTOs\ReviewsDTO;

/**
 * Class HTMLFactory
 *
 * @package Otushw\Factory\HTML
 */
class HTMLFactory extends ArticleFactory
{

    /**
     * @param NewsDTO $raw
     *
     * @return News
     */
    public function createNews(NewsDTO $raw): News
    {
        $news = new NewsHTML($raw);
        $this->notify($news);

        return $news;
    }

    /**
     * @param ReviewsDTO $raw
     *
     * @return Reviews
     */
    public function createReviews(ReviewsDTO $raw): Reviews
    {
        $review = new ReviewsHTML($raw);
        $this->notify($review);

        return $review;
    }


}
