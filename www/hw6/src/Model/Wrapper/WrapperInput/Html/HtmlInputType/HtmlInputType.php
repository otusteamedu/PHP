<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Wrapper\WrapperInput\Html\HtmlInputType;

use Nlazarev\Hw6\Model\Wrapper\WrapperInput\Html\HtmlInputCustom;

class HtmlInputType extends HtmlInputCustom
{
    public function get(): string
    {
        $input = parent::get();
        return rtrim($input, ">") . ' type="' . $this->param . '">';
    }
}
