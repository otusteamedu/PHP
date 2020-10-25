<?php

namespace App\Core\Templates\TemplateAbstractFactory\Factory;

use App\Core\Templates\TemplateAbstractFactory\Product\PageTemplate\PageTemplateInterface;
use App\Core\Templates\TemplateAbstractFactory\Product\TemplateRenderer\TemplateRendererInterface;

interface TemplateFactoryInterface
{
    public function createPageEntityTemplate(): PageTemplateInterface;

    public function getRenderer(): TemplateRendererInterface;
}