<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Wrapper\WrapperArticle\WrapperReview;

use Nlazarev\Hw6\Model\Wrapper\WrapperArticle\IWrapperArticle;

class WrapperReviewHtml extends WrapperReview implements IWrapperArticle
{
    public function build()
    {
        return "<div>" . 
            "<h1>" . $this->getReview()->getHeader() . "</h1>" . 
            "<p>" . $this->getReview()->getMainText() . "</p>" . 
            "<p>" . $this->getReview()->getRating() . "</p>" . 
            "</div>"; 
    }
}
