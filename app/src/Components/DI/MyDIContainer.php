<?php

namespace App\Components\DI;

use App\Components\DI\Exceptions\ContainerException;
use App\Components\DI\Exceptions\DependencyException;
use App\Components\DI\Exceptions\EntityException;
use App\Components\DI\Exceptions\EntityNotFoundException;
use App\Interfaces\ContainerInterface;

class MyDIContainer implements ContainerInterface
{
    private $entitys;
    private $entityStore;
    private $config;
    private $shared;

    public function __construct(array $config = [], array $entitys = []) {
        $this->entitys = $entitys;
        $this->config = $config;
        $this->entityStore = [];
    }

    public function set(string $key, string $name, bool $shared = false): void {
        $this->entitys[$key] = $name;
        $this->shared[$key] = $shared;
    }

    public function singleton(string $key, string $name) {
        $this->set($key, $name, true);
    }

    public function setConfig(array $config): void {
        $this->config = $config;
    }

    public function get(string $key): object {
        if (!$this->has($key)) {
            throw new EntityNotFoundException('Service not found: ' . $key);
        }
        if ($this->shared[$key] === true) {
            return $this->getSingletonEntity($key);
        }
        return $this->createEntity($key);
    }

    public function has(string $key): bool {
        return isset($this->entitys[$key]);
    }

    private function getSingletonEntity(string $key) {
        if (empty($this->entityStore[$key])) {
            $this->entityStore[$key] = $this->createEntity($key);
        }
        return $this->entityStore[$key];
    }

    private function createEntity(string $key): object {
        $entity = $this->entitys[$key];
        $entity = $this->checkEntityType($entity);
        $reflector = new \ReflectionClass($entity);
        $dependencies = $this->getDependencies($reflector);

        return $reflector->newInstanceArgs($dependencies);
    }

    private function checkEntityType(string $entity) {
        if (class_exists($entity)) {
            return $entity;
        }
        if (interface_exists($entity)) {
            return $this->getIndicatedClassNameForInterface($entity);
        }
        throw new ContainerException('Класса или интерфейса не существует');
    }

    private function getDependencies(\ReflectionClass $reflectionClass): array {
        try {
            $dependencyList = $this->addDependencies($reflectionClass);
        } catch (DependencyException $e) {
            return [];
        }
        return $this->createDependencies($dependencyList);
    }

    private function createDependencies(array $dependencyList): array {
        foreach ($dependencyList as $key => $dependencyName) {
            $dependencies[] = new $dependencyName();
        }
        return $dependencies;
    }

    private function addDependencies(\ReflectionClass $reflectionClass): array {
        try {
            $constructor = $this->getConstructor($reflectionClass);
        } catch (EntityException $e) {
            throw new DependencyException('Класс не содержит зависимостей');
        }
        $constructorParams = $constructor->getParameters();
        foreach ($constructorParams as $dependency) {
            $dependencyName = $dependency->getClass()->getName();
            if (!class_exists($dependencyName)) {
                $dependencyList[] = $this->getIndicatedDependency($reflectionClass, $dependency);
                continue;
            }
            $dependencyList[] = $dependencyName;
        }
        return $dependencyList;
    }

    private function getIndicatedDependency(\ReflectionClass $reflectionClass, \ReflectionParameter $dependency): string {
        $dependencyName = $dependency->getClass()->getShortName();
        $entityName = $reflectionClass->getShortName();
        $indicatedDependency = $this->getIndicatedDependencyName($entityName, $dependencyName);
        if (!$indicatedDependency) {
            throw new ContainerException('Ошибка в настройке конфиг файла');
        }
        return $indicatedDependency;
    }

    private function getIndicatedDependencyName(string $entityName, string $dependencyName): string {
        return $this->config[$entityName][$dependencyName];
    }

    private function getIndicatedClassNameForInterface(string $entityName): string {
        return $this->config[$entityName];
    }

    private function getConstructor(\ReflectionClass $reflectionClass): \ReflectionMethod {
        $constructor = $reflectionClass->getConstructor();
        if (empty($constructor)) {
            throw new EntityException('Класс не содержит конструктора');
        }
        return $constructor;
    }
}