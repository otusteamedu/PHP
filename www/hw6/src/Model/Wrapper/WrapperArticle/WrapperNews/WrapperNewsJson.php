<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Wrapper\WrapperArticle\WrapperNews;

use Nlazarev\Hw6\Model\Wrapper\WrapperArticle\IWrapperArticle;

class WrapperNewsJson extends WrapperNews implements IWrapperArticle
{
    public function build()
    {
        return json_encode(
            array(
            'header' => $this->getNews()->getHeader(),
            'main_text' => $this->getNews()->getMainText(),
            'source' => $this->getNews()->getSource()
            )
        );
    }
}
