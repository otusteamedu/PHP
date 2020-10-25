<?php

namespace App\Core\Templates\TemplateAbstractFactory\Factory;

use App\Core\Templates\TemplateAbstractFactory\Product\PageTemplate\PageTemplateInterface;
use App\Core\Templates\TemplateAbstractFactory\Product\PageTemplate\TwigPageTemplate;
use App\Core\Templates\TemplateAbstractFactory\Product\TemplateRenderer\TemplateRendererInterface;
use App\Core\Templates\TemplateAbstractFactory\Product\TemplateRenderer\TwigRenderer;

class TwigTemplateFactory implements TemplateFactoryInterface
{
    public function createPageEntityTemplate(): PageTemplateInterface
    {
        return new TwigPageTemplate();
    }

    public function getRenderer(): TemplateRendererInterface
    {
        return new TwigRenderer();
    }
}