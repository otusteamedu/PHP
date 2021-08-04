<?php


namespace Services\Dao\IdentityMap;


/**
 * Class ObjectsHolder
 *
 * Хранилище извлекаемых из различных таблиц объектов
 *
 * @package Services\Dao\IdentityMap
 */
class ObjectsHolder
{
    private static self $_instance;
    private array $objects;

    /**
     * Возвращает единственный экземпляр класса
     *
     * @return static
     */
    public static function getInstance(): self
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Возвращает Объект сохраненный в массиве по id
     *
     * @param string $className
     * @param int $id
     * @return mixed
     */
    public static function getRecord(string $className, int $id): mixed
    {
        $inst = self::getInstance();
        $key = "$className.$id";
        return (isset($inst->objects[$key]))
            ? $inst->objects[$key]
            : null;
    }

    /**
     * Добавляет Объект в массиве по id
     *
     * @param $object
     * @param int $id
     */
    public static function addRecord($object, int $id): void
    {
        $inst = self::getInstance();
        $inst->objects[$inst->getKey($object, $id)] = $object;
    }

    /**
     * Формирует ключ для хранения Объекта по id
     *
     * @param $object
     * @param int $id
     * @return string
     */
    private function getKey($object, int $id): string
    {
        return get_class($object).'.'.$id;
    }

}
