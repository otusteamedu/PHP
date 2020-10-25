<?php

namespace App\Core\Templates\TemplateAbstractFactory\Product\PageTemplate;

interface PageTemplateInterface
{
    public function getEntityTemplateString(): string;

    public function getTemplateString(string $templateName): string;
}