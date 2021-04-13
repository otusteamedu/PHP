<?php

namespace App\Services\IdentityMap;

use App\Entities\Entity;
use Illuminate\Support\Collection;

class EntityStorage
{
    private static ?self $instance = null;

    private Collection $objects;

    private function __construct()
    {
        $this->objects = collect();
    }

    public static function getInstance() : self
    {
        if(is_null(self::$instance)){
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function add(Entity $entity) : bool
    {
        if($this->isExist($entity)){
            return false;
        }

        $this->objects->put($this->getHash($entity), $entity);

        return true;
    }

    public function remove(Entity $entity) : bool
    {
        if($this->isExist($entity)){
            return false;
        }

        $this->objects->forget($this->getHash($entity));

        return true;
    }

    public function update(Entity $entity) : bool
    {
        if(!$this->remove($entity)){
            return false;
        }

        return $this->add($entity);
    }

    public function get(string $className, int $id) : ?Entity
    {
        if(!class_exists($className)){
            return null;
        }

        $entity = new $className();

        if(false === ($entity instanceof Entity)){
            return null;
        }

        $entity->setId($id);

        if(!$this->isExist($entity)){
            return null;
        }

        return $this->objects->get($this->getHash($entity));
    }

    public function isExist(Entity $entity) : bool
    {
        return $this->objects->has($this->getHash($entity));
    }

    private function getHash(Entity $entity) : string
    {
        return get_class($entity) . $entity->getId();
    }
}