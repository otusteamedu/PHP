<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Wrapper\WrapperInput\Html;

class HtmlInput implements IHtmlInput
{
    public function get(): string
    {
        return "<input>";
    }
}
