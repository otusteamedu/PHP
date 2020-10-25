<?php

namespace App\Core\Templates\TemplateAbstractFactory\Product\PageTemplate;

class TwigPageTemplate implements PageTemplateInterface
{
    public function getEntityTemplateString(): string
    {
        return <<<HTML
        <div class="page">
            {{ content }}
        </div>
        HTML;
    }

    public function getTemplateString(string $templateName): string
    {
        //чтение HTML из файла с вставками для TwigTemplateRender
        // TODO: Implement getHeaderTemplateString() method.
    }
}
