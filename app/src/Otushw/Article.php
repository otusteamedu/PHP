<?php


namespace Otushw;

use Otushw\DTOs\ArticleDTO;
use Otushw\DTOs\NewsDTO;
use Otushw\DTOs\ReviewsDTO;
use Otushw\Exception\AppException;
use Otushw\Factory\ArticleFactory;
use Otushw\Factory\HTML\HTMLArticleFactory;
use Otushw\Factory\News;
use Otushw\Factory\Reviews;
use Otushw\Factory\XML\XMLArticleFactory;
use Otushw\Observer\ObserverInterface;
use Otushw\Factory\Article as ArticleInterface;

class Article
{
    private string $format;
    private array $observers = [];

    public function __construct(string $format)
    {
        $this->format = strtoupper($format);
    }

    /**
     * Создал такой метод, для того чтобы не дублировать метод вызова Наблюдателя,
     * в каждой реализации generateNews и generateReviews
     *
     * @param NewsDTO | ReviewsDTO $article
     *
     * @return News | Reviews $readyArticle.
     *
     * @throws AppException
     */
    public function create($article)
    {
        $typeArticle = $this->getTypeArticle($article);
        switch ($typeArticle) {
            case 'news':
                $readyArticle = $this->generateNews($article);
                break;
            case 'reviews':
                $readyArticle = $this->generateReviews($article);
                break;
        }

        $this->notify($readyArticle);
        return $readyArticle;
    }

    private function generateNews(NewsDTO $rawNews): News
    {
        $factory = $this->getFactory($this->format);
        $news = $factory->createNews($rawNews);
        $render = $factory->getRender('news');
        $news->setRender($render);
        return $news;
    }

    private function generateReviews(ReviewsDTO $rawReviews): Reviews
    {
        $factory = $this->getFactory($this->format);
        $reviews = $factory->createReviews($rawReviews);
        $render = $factory->getRender('reviews');
        $reviews->setRender($render);
        return $reviews;
    }

    private function getFactory(string $typeFactory): ArticleFactory
    {
        switch ($typeFactory) {
            case 'HTML':
                return new HTMLArticleFactory();
            case 'XML':
                return new XMLArticleFactory();
        }
    }

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

    private function notify(ArticleInterface $article): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($article);
        }
    }

    private function getTypeArticle($article): string
    {
        $classNameFull = get_class($article);
        $function = new \ReflectionClass($classNameFull);
        $classNameShort = strtolower($function->getShortName());
        preg_match('/([a-z]+)dto/', $classNameShort, $matches);
        if (empty($matches[1])) {
            throw new AppException('Only accepts classes *DTO');
        }
        return $matches[1];
    }

}