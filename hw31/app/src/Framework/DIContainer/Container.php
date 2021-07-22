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
    private function getArgsFromMethod(ReflectionMethod $method, array $params = []): array
    {
        $args = [];

        foreach ($method->getParameters() as $arg) {
            if ($arg->getType()->isBuiltin()) {
                if (array_key_exists($arg->name, $params) !== false) {
                    $args[$arg->name] = $params[$arg->name];
                }
                continue;
            }

            $class = $arg->getClass();

            if ($class !== null) {
                if ((array_key_exists($arg->name, $params) !== false) and $params[$arg->name] instanceof $class) {
                    $args[$arg->name] = $params[$arg->name];
                } else {
                    $args[$arg->name] = $this->get($class->getName());
                }
            } elseif ($arg->isDefaultValueAvailable()) {
                $args[$arg->name] = $arg->getDefaultValue();
            } else {
                throw new UnexpectedValueException("Неопределен класс для $arg->name");
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
    public function callMethod(object $classInstance, string $methodName, array $params = [])
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

        $args = $this->getArgsFromMethod($reflectionMethod, $params);

        //$args = array_merge($args, $params);

        return $reflectionMethod->invokeArgs($classInstance, $args);
    }
}