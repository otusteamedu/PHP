<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Wrapper\WrapperInput\Html\HtmlInputPlaceholder;

use Nlazarev\Hw6\Model\Wrapper\WrapperInput\Html\HtmlInputCustom;

class HtmlInputPlaceholder extends HtmlInputCustom
{
    public function get(): string
    {
        $input = parent::get();
        return rtrim($input, ">") . ' placeholder="' . $this->param . '">';
    }
}
