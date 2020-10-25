<?php

namespace App\Core\Templates\TemplateAbstractFactory\Factory;

use App\Core\Templates\TemplateAbstractFactory\Product\PageTemplate\PageTemplateInterface;
use App\Core\Templates\TemplateAbstractFactory\Product\PageTemplate\PHPPageTemplate;
use App\Core\Templates\TemplateAbstractFactory\Product\TemplateRenderer\PHPTemplateRenderer;
use App\Core\Templates\TemplateAbstractFactory\Product\TemplateRenderer\TemplateRendererInterface;

class PHPTemplateFactory implements TemplateFactoryInterface
{
    public function createPageEntityTemplate(): PageTemplateInterface
    {
        return new PHPPageTemplate();
    }

    public function getRenderer(): TemplateRendererInterface
    {
        return new PHPTemplateRenderer();
    }
}