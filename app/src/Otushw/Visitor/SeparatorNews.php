<?php


namespace Otushw\Visitor;

use Otushw\Factory\News;
use Otushw\Factory\Reviews;

class SeparatorNews implements Visitor
{

    private array $articles;

    public function __construct(array $articles)
    {
        $this->articles = $articles;
    }

    public function visitNews(News $news): void
    {
        // Задача для посетиля убрать все кроме новостей,
        // поэтому этот метод оставляю пустым.
        // Или его вообще не нужно было объявлять в интерфейсе?
    }

    public function visitReviews(Reviews $reviews): void
    {
        $this->revomeReviews($reviews);
    }

    public function getNews(): array
    {
        return $this->articles;
    }


    private function revomeReviews(Reviews $reviews)
    {
        $buf = $this->articles;
        foreach ($this->articles as $ky => $article) {
            if ($article === $reviews) {
                unset($this->articles[$ky]);
            }
        }
    }


}