<?php


namespace Otushw\Factory;

use Otushw\DTOs\NewsDTO;
use Otushw\DTOs\ReviewsDTO;
use Otushw\Article;
use Otushw\Models\News;
use Otushw\Models\Reviews;
use Otushw\Observer\Observable;
use Otushw\Observer\ObserverInterface;

abstract class ArticleFactory implements Observable
{
    private array $observers = [];

    public function attach(ObserverInterface $observer): void
    {
        $this->observers[] = $observer;
    }

    public function detach(ObserverInterface $observer): void
    {
        foreach ($this->observers as &$search) {
            if ($search === $observer) {
                unset($search);
            }
        }
    }

    public function notify(Article $article): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($article);
        }
    }

//    public function createNews(NewsDTO $raw): News
//    {
//        $news = new News($raw);
//        $this->notify($news);
//
//        return $news;
//    }
//
//    public function createReviews(ReviewsDTO $raw): Reviews
//    {
//        $review = new Reviews($raw);
//        $this->notify($review);
//
//        return $review;
//    }

    abstract public function createNews(NewsDTO $raw): News;

    abstract public function createReviews(ReviewsDTO $raw): Reviews;

    abstract public function renderNews(News $news): void;

    abstract public function renderReviews(Reviews $reviews): void;
}
