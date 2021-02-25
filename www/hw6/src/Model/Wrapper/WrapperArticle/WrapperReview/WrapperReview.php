<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Wrapper\WrapperArticle\WrapperReview;

use Nlazarev\Hw6\Model\Article\Review\IReview;
use Nlazarev\Hw6\Model\Wrapper\WrapperArticle\IWrapperArticle;

abstract class WrapperReview implements IWrapperArticle
{
    private IReview $review; 
    
    public function __construct(IReview $review)
    {
        $this->review = $review;
    }

    public function getReview()
    {
        return $this->review;
    }

    public function setReview($review)
    {
        $this->review = $review;

        return $this;
    }

    abstract function build();
}
