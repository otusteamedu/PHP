<?php

namespace Bjlag;

abstract class BaseController
{
    /**
     * @param string $template
     * @param array $params
     * @return string
     */
    protected function render(string $template, array $params = []): string
    {
        return App::getTemplate()->render($template, $params);
    }
}
