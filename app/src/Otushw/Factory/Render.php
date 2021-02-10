<?php


namespace Otushw\Factory;

use Otushw\Article;
use Otushw\Exception\AppException;

class Render
{
    const TEMPLATE_FOLDER = 'template';

    private string $pathTemplate;
    private array $tokens = [];

    public function __construct(string $format, string $templateName)
    {
        $templateName = $templateName . '.' . strtolower($format);
        $folderName = [strtoupper($format), self::TEMPLATE_FOLDER, $templateName];
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

    /**
     * Adds tokens which can use in template.
     *
     * @param string $tokenName
     * @param mixed $tokenValue
     */
    public function addToken(string $tokenName, $tokenValue): void
    {
        $tokenName = '%%' . strtoupper($tokenName) . '%%';
        $this->tokens[$tokenName] = $tokenValue;
    }

    public function render(Article $article): void
    {
        $this->prepareTokens($article);
        $content = file_get_contents($this->pathTemplate);
        echo $this->replaceTokens($content);
    }

    private function prepareTokens(Article $article): void
    {
        $methods = $this->getMethods($article);
        foreach ($methods as $methodName) {
            preg_match('/get([A-Z]([a-z]|[A-Z])+)/', $methodName, $matches);
            if (!empty($matches[1])) {
                $tokenName = $this->generateTokenName($matches[1]);
                $this->tokens[$tokenName] = $article->$methodName();
            }
        }
    }

    /**
     * Возможно это не очень хорошее решение получать таким образом методы,
     * от News и Reviews, но оба наследуются от Article,
     * я попробовал отдает только public.
     */
    private function getMethods(Article $article): array
    {
        $className = get_class($article);
        $methods = get_class_methods($className);
        $allowedMethods = [];
        foreach ($methods as $methodName) {
            if (strpos($methodName, 'get') !== false) {
                $allowedMethods[] = $methodName;
            }
        }
        return $allowedMethods;
    }

    private function generateTokenName(string $tokenName): string
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
