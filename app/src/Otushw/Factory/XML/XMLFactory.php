<?php


namespace Otushw\Factory\XML;

use Otushw\Factory\ArticleFactory;
use Otushw\Models\News;
use Otushw\DTOs\NewsDTO;
use Otushw\Models\Reviews;
use Otushw\DTOs\ReviewsDTO;

class XMLFactory extends ArticleFactory
{

    /**
     * @param NewsDTO $raw
     *
     * @return News
     */
    public function createNews(NewsDTO $raw): News
    {
        $news = new NewsXML($raw);
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
        $review = new ReviewsXML($raw);
        $this->notify($review);

        return $review;
    }


}