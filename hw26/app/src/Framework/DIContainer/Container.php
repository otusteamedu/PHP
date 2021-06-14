<?php

declare(strict_types=1);

namespace App\Framework\DIContainer;

use Closure;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use UnexpectedValueException;

class Container implements ContainerInterface
{
    private array $bindings          = [];
    private array $instances         = [];
    private array $reflectionClasses = [];

    /**
     * @throws ReflectionException
     */
    public function get(string $abstract): object
    {
        if ($this->isDiContainer($abstract)) {
            return $this;
        }

        if (!$this->has($abstract)) {
            $this->throwExceptionIfClassNotFound($abstract);

            $this->set($abstract);
        }

        if (!empty($this->hasInstance($abstract))) {
            return $this->getInstance($abstract);
        }

        $concreteImpl = $this->getConcreteImpl($abstract);

        if ($concreteImpl instanceof Closure) {
            $instance = $this->createInstanceFromClosure($concreteImpl);
        } else {
            $instance = $this->createInstanceFromClassName($concreteImpl);
        }

        $this->setInstance($abstract, $instance);

        return $instance;
    }

    private function isDiContainer(string $className): bool
    {
        return ($className === ContainerInterface::class);
    }

    private function throwExceptionIfClassNotFound(string $className): void
    {
        if (!class_exists($className)) {
            throw new UnexpectedValueException("Класс $className не найден");
        }
    }

    private function hasInstance(string $abstract): bool
    {
        return !empty($this->instances[$abstract]);
    }

    private function getInstance(string $abstract): object
    {
        return $this->instances[$abstract];
    }

    private function setInstance(string $abstract, $instance): void
    {
        $this->instances[$abstract] = $instance;
    }

    private function getConcreteImpl(string $abstract)
    {
        return $this->bindings[$abstract];
    }

    private function createInstanceFromClosure(Closure $closure): object
    {
        return call_user_func($closure);
    }

    /**
     * @throws ReflectionException
     */
    private function createInstanceFromClassName(string $className): object
    {
        $reflectionClass = $this->getReflectionClass($className);

        if (!$constructor = $reflectionClass->getConstructor()) {
            return new $className();
        }

        $args = $this->getArgsFromMethod($constructor);

        return $reflectionClass->newInstanceArgs($args);
    }

    /**
     * @throws ReflectionException
     */
    private function getArgsFromMethod(ReflectionMethod $method): array
    {
        $args = [];

        foreach ($method->getParameters() as $param) {
            $class = $param->getClass();

            if ($class !== null) {
                $args[$param->name] = $this->get($class->getName());
            } elseif ($param->isDefaultValueAvailable()) {
                $args[$param->name] = $param->getDefaultValue();
            } else {
                throw new UnexpectedValueException("Неопределен класс для $param->name");
            }
        }

        return $args;
    }

    /**
     * @throws ReflectionException
     */
    private function getReflectionClass(string $className): ReflectionClass
    {
        if (isset($this->reflectionClasses[$className])) {
            return $this->reflectionClasses[$className];
        }

        return $this->reflectionClasses[$className] = new ReflectionClass($className);
    }

    public function has(string $abstract): bool
    {
        return !empty($this->bindings[$abstract]);
    }

    public function set(string $abstract, $concreteImpl = null): void
    {
        $this->bindings[$abstract] = ($concreteImpl ? : $abstract);

        if (is_object($concreteImpl) and is_a($concreteImpl, $abstract)) {
            $this->setInstance($abstract, $concreteImpl);
        }
    }

    /**
     * @return mixed
     * @throws ReflectionException
     */
    public function callMethod(object $classInstance, string $methodName)
    {
        $className = get_class($classInstance);

        $reflectionClass = $this->getReflectionClass($className);

        if (!$reflectionClass->hasMethod($methodName)) {
            throw new UnexpectedValueException("Метод $methodName не найден в классе $className");
        }

        $reflectionMethod = $reflectionClass->getMethod($methodName);

        if (!$reflectionMethod->isPublic()) {
            throw new UnexpectedValueException("Метод $methodName класса $className не является публичным");
        }

        $args = $this->getArgsFromMethod($reflectionMethod);

        return $reflectionMethod->invokeArgs($classInstance, $args);
    }
}