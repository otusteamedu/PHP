<?php


namespace Services\Traits;


use ReflectionClass;

/**
 * Trait HasObjectTools
 * Набор тулзов для работы с объектам
 *
 * @package Services\Traits
 */
trait HasObjectTools
{
    /**
     * Возвращает объект в виде массива
     *
     * @return array
     */
    public function asArray(): array
    {
        $array = [];
        foreach (array_keys($this->getProperties()) as $property) {
            $array[$property] = $this->{$property};
        }
        return $array;
    }

    /**
     * Возвращает набор свойств объекта в виде ключей массива с нулевыми значениями
     *
     * @return array
     */
    private function getProperties(): array
    {
        $properties = [];
        foreach ((new ReflectionClass($this))->getProperties() as $property) {
            $properties[$property->getName()] = null;
        }
        return $properties;
    }
}
