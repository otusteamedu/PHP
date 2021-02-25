<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Article\Review;

use Nlazarev\Hw6\Model\Article\Article;
use Nlazarev\Hw6\Model\Article\IArticleVisitor;

class Review extends Article implements IReview
{
    private int $rating;

    public function __construct(string $header, string $main_text, int $rating)
    {
        $this->setHeader($header)
            ->setMainText($main_text)
            ->setRating($rating);
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function setRating(int $rating)
    {
        $this->raitng = $rating;
    }

    public function accept(IArticleVisitor $visitor)
    {
        $visitor->visitReview($this);
    }
}