<?php

declare(strict_types=1);

namespace Otus\hw22\Model;

use Otus\hw22\Helper\CamelCase;
use Otus\hw22\Mapper\Relation;

abstract class BaseModel
{
    /**
     * @var array
     */
    protected $relations = [];

    public function __construct(array $config = [])
    {
        foreach ($config as $key => $value) {
            $method = (new CamelCase('set-' . $key))();
            if (method_exists($this, $method)) {
                call_user_func_array([$this, $method], $value);
            }
        }
    }

    public function setRelation(string $name, Relation $relation): void
    {
        $this->relations[$name] = $relation;
    }

    public function getRelation($name): ?Relation
    {
        return $this->relations[$name] ?? null;
    }

    public function related(string $name)
    {
        return $this->relations[$name] ? $this->relations[$name]() : null;
    }
}