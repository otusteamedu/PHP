<?php


namespace App\Services\Orm;


use App\Services\Orm\Interfaces\OrmModelInterface;

final class IdentityMap
{
    private static ?IdentityMap $instance = null;
    private array $items;

    public static function getInstance(): IdentityMap
    {
        if (self::$instance === null) {
            self::$instance = new IdentityMap();
        }

        return self::$instance;
    }


    public function set(OrmModelInterface $model): void
    {
        $key = $this->getKey($model);
        self::$instance->items[$key] = $model;
    }

    public function get(string $className, int $id): ?OrmModelInterface
    {
        $key = $className . ':' . $id;

        if (isset(self::$instance->items[$key])) {
            return self::$instance->items[$key];
        }

        return null;
    }

    public function delete(OrmModelInterface $model): void
    {
        $key = $this->getKey($model);
        unset($this->items[$key]);
    }

    private function getKey(OrmModelInterface $model): string
    {
        return get_class($model) . ':' . $model->getId();
    }

    private function __construct(){}
    private function __clone(){}
}
