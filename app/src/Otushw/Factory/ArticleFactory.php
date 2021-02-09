<?php


namespace Otushw\Factory;

use Otushw\DTOs\NewsDTO;
use Otushw\DTOs\ReviewsDTO;
use Otushw\Models\News;
use Otushw\Models\Reviews;
use Otushw\Article;
use Otushw\Observer\Observable;
use Otushw\Observer\ObserverInterface;

/**
 * Class ArticleFactory
 *
 * @package Otushw\Factory
 */
abstract class ArticleFactory implements Observable
{
    /**
     * @var array
     */
    private array $observers = [];

    /**
     * @param ObserverInterface $observer
     *
     * @return void
     */
    public function attach(ObserverInterface $observer): void
    {
        $this->observers[] = $observer;
    }

    /**
     * @param ObserverInterface $observer
     *
     * @return void
     */
    public function detach(ObserverInterface $observer): void
    {
        foreach ($this->observers as &$search) {
            if ($search === $observer) {
                unset($search);
            }
        }
    }


    /**
     * @param Article $article
     *
     * @return void
     */
    public function notify(Article $article): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($article);
        }
    }

    /**
     * @param NewsDTO $raw
     *
     * @return News
     */
    abstract public function createNews(NewsDTO $raw): News;

    /**
     * @param ReviewsDTO $raw
     *
     * @return Reviews
     */
    abstract public function createReviews(ReviewsDTO $raw): Reviews;
}
