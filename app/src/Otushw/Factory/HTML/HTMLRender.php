<?php


namespace Otushw\Factory\HTML;

use Otushw\Factory\Article;
use Otushw\Factory\Render;
use Otushw\Exception\AppException;

class HTMLRender extends Render
{

    private string $pathTemplate;
    private array $tokens = [];

    public function __construct(string $templateName)
    {
        $templateName = $templateName . '.html';
        $folderName = ['template', $templateName];
        $pathTemplate = $this->generatePath($folderName);
        if (!file_exists($pathTemplate)) {
            throw new AppException('Template does not exist! File: ' . $templateName);
        }
        $this->pathTemplate = $pathTemplate;
    }

    private function generatePath(array $folderName): string
    {
        $path = __DIR__;
        foreach ($folderName as $item) {
            $path .= DIRECTORY_SEPARATOR . $item;
        }

        return $path;
    }

    public function render(Article $article): void
    {
        $properties = $this->prepareProperty($article);
        $this->tokens = $properties;
        $content = file_get_contents($this->pathTemplate);
        echo $this->replaceTokens($content);
    }

    protected function generatePropertyName(string $tokenName): string
    {
        return '%%' . strtoupper($tokenName) . '%%';
    }

    private function replaceTokens(string $content): string
    {
        foreach ($this->tokens as $tokenName => $tokenValue) {
            $content = str_replace($tokenName, $tokenValue, $content);
        }
        return $content;
    }
}