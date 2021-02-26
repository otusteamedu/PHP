<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Article\Review;

use Nlazarev\Hw6\Model\Article\IArticle;

interface IReview extends IArticle
{
    public function getRating(): int;
    public function setRating(int $rating);
}
