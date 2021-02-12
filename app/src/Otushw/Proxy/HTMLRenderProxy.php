<?php


namespace Otushw\Proxy;

use Otushw\Factory\HTML\HTMLArticleFactory;
use Otushw\Factory\Render;

class HTMLRenderProxy
{
    private string $templateName;

    private array $cache;

    public function __construct(string $templateName)
    {
        $this->templateName = $templateName;
    }

    public function getRender(): Render
    {
        if (empty($this->cache[$this->templateName])) {
            $factory = new HTMLArticleFactory();
            $render = $factory->getRender($this->templateName);
            $this->cache[$this->templateName] = $render;
        }
        return $this->cache[$this->templateName];
    }

}