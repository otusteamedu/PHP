<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Wrapper\WrapperArticle\WrapperReview;

use Nlazarev\Hw6\Model\Wrapper\WrapperArticle\IWrapperArticle;

class WrapperReviewXml extends WrapperReview implements IWrapperArticle
{
    public function build()
    {
        return "<review>" . 
            "<header>" . $this->getReview()->getHeader() . "</header>" . 
            "<main_text>" . $this->getReview()->getMainText() . "</main_text>" . 
            "<raiting>" . $this->getReview()->getRating() . "</raiting>" . 
            "</review>"; 
    }
}
