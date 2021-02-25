<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Wrapper\WrapperArticle\WrapperNews;

use Nlazarev\Hw6\Model\Wrapper\WrapperArticle\IWrapperArticle;

class WrapperNewsHtml extends WrapperNews implements IWrapperArticle
{
    public function build()
    {
        return "<div>" . 
            "<h1>" . $this->getNews()->getHeader() . "</h1>" . 
            "<p>" . $this->getNews()->getMainText() . "</p>" . 
            "<p>" . $this->getNews()->getSource() . "</p>" . 
            "</div>"; 
    }
}
