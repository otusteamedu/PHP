<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Wrapper\WrapperArticle\WrapperReview;

use Nlazarev\Hw6\Model\Wrapper\WrapperArticle\IWrapperArticle;

class WrapperReviewJson extends WrapperReview implements IWrapperArticle
{
    public function build()
    {
        return json_encode(array(
            'header' => $this->getReview()->getHeader(), 
            'main_text' => $this->getReview()->getMainText(), 
            'raiting' => $this->getReview()->getRating()
            )
        );
    }
}
