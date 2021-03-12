<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Wrapper\WrapperInput\Html;

class HtmlInputCustom implements IHtmlInput
{
    private IHtmlInput $html_input;
    protected string $param;

    public function __construct(IHtmlInput $html_input, $param = "")
    {
        $this->html_input = $html_input;
        $this->param = $param;
    }

    public function get(): string
    {
        return $this->html_input->get();
    }
}
