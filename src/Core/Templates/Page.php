<?php


namespace App\Core\Templates;

use App\Core\Templates\TemplateAbstractFactory\Factory\TemplateFactoryInterface;

abstract class Page
{
    public string $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function renderEntity(TemplateFactoryInterface $factory): string
    {
        // вернет класс PHPTemplate, например
        $pageTemplate = $factory->createPageEntityTemplate();

        // вернет класс PHPTemplateRenderer
        $renderer = $factory->getRenderer();

        return $renderer->render($pageTemplate->getEntityTemplateString(), [
            'content' => $this->content
        ]);
    }

    public function renderFullPage(TemplateFactoryInterface $factory, string $templateName): string
    {
        $pageTemplate = $factory->createPageEntityTemplate();
        $renderer = $factory->getRenderer();

        return $renderer->render($pageTemplate->getTemplateString($templateName));
    }
}