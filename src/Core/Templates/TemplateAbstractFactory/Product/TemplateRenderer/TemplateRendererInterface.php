<?php

namespace App\Core\Templates\TemplateAbstractFactory\Product\TemplateRenderer;

interface TemplateRendererInterface
{
    public function render(string $templateString, array $arguments = []): string;
}