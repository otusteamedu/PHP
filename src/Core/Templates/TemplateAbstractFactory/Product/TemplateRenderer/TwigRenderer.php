<?php

namespace App\Core\Templates\TemplateAbstractFactory\Product\TemplateRenderer;

class TwigRenderer implements TemplateRendererInterface
{
    public function render(string $templateString, array $arguments = []): string
    {
        return \Twig::render($templateString, $arguments);
    }
}