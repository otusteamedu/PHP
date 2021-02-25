<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Wrapper\WrapperArticle\WrapperNews;

use Nlazarev\Hw6\Model\Wrapper\WrapperArticle\IWrapperArticle;

class WrapperNewsXml extends WrapperNews implements IWrapperArticle
{
    public function build()
    {
        return "<news>" . 
            "<header>" . $this->getNews()->getHeader() . "</header>" . 
            "<main_text>" . $this->getNews()->getMainText() . "</main_text>" . 
            "<source>" . $this->getNews()->getSource() . "</source>" . 
            "</news>"; 
    }
}
