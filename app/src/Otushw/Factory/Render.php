<?php


namespace Otushw\Factory;

abstract class Render
{

    /**
     * Подготавливает специальный массив со свойствами объектов.
     * Для каждого Render'a имеет определенный формат.
     *
     * @param Article $article
     *
     * @return array
     */
    protected function prepareProperty(Article $article): array
    {
        $properties = [];
        $methods = $this->getMethods($article);
        foreach ($methods as $methodName) {
            preg_match('/get([A-Z]([a-z]|[A-Z])+)/', $methodName, $matches);
            if (!empty($matches[1])) {
                $tokenName = $this->generatePropertyName($matches[1]);
                $properties[$tokenName] = $article->$methodName();
            }
        }
        return $properties;
    }

    /**
     * Возможно это не очень хорошее решение получать таким образом методы,
     * от News и Reviews, но оба наследуются от Article,
     * я попробовал отдает только public.
     *
     * @param Article $article
     *
     * @return array
     */
    protected function getMethods(Article $article): array
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

    abstract protected function generatePropertyName(string $propertyName): string;

    abstract public function render(Article $article): void;
}
