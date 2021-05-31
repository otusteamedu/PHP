<?php


namespace App;


class Container
{

    private static $inst;

    private array $entries = [];

    protected array $instances = [];

    protected array $rules = [
        'shared'     => [],
        'substitute' => [],
    ];

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    public static function getInstance(): Container
    {
        if (!self::$inst) {
            self::$inst = new self();
        }
        return self::$inst;
    }

    public function get($id, array $arguments = [])
    {
        if (!$this->has($id)) {
            $this->set($id);
        }
        $entry = $this->entries[$id];
        if ($entry instanceof \Closure || is_callable($entry)) {
            return $entry($this, $arguments);
        }

        if (isset($this->rules['shared']) && in_array($id, $this->rules['shared'])) {
            return $this->singleton($id);
        }
        return $this->resolve($id, $arguments);
    }

    public function has($id)
    {
        return isset($this->entries[$id]);
    }

    public function set($abstract, $concrete = null)
    {
        $this->entries[$abstract] = $concrete ?? $abstract;
        return $this;
    }

    public function resolve($alias, $arguments = [])
    {
        $reflector = $this->getReflection($alias);
        $constructor = $reflector->getConstructor();
        if ($reflector->isInterface()) {
            return $this->resolveInterface($reflector);
        }
        if (!$reflector->isInstantiable()) {
            throw new \Exception('not initiabl;e');
        }

        if ($constructor === null) {
            return $reflector->newInstance();
        }

        $args = $this->getArguments($alias, $constructor, $arguments);
        return $reflector->newInstanceArgs($args);

    }

    public function getReflection($alias): \ReflectionClass
    {
        return (new \ReflectionClass($this->entries[$alias]));
    }

    public function singleton($alias)
    {
        if (!isset($this->instances[$alias])) {
            $this->instances[$alias] = $this->resolve($this->entries[$alias]);
        }
        return $this->instances[$alias];
    }

    public function getArguments($alias, \ReflectionMethod $method, $arguments = [])
    {
        $args = [];
        $params = $method->getParameters();
        foreach ($params as $param) {
            if (array_key_exists($param->getName(), $arguments)) {
                $args[] = $arguments[$param->getName()];
            } elseif ($param->getClass() !== null) {
                $args[] = $this->get($param->getClass()->getName());
            } else if ($param->isDefaultValueAvailable()) {
                $args[] = $param->getDefaultValue();
            } elseif (isset($this->rules[$alias][$param->getName()])) {
                $args[] = $this->rules[$alias][$param->getName()];
            }
        }
        return $args;
    }

    public function resolveInterface(\ReflectionClass $reflectionClass)
    {
        if (isset($this->rules['substitute'][$reflectionClass->getName()])) {
            return $this->get($this->rules['substitute'][$reflectionClass->getName()]);
        }
        $classes = get_declared_classes();
        foreach ($classes as $class) {
            $rf = new \ReflectionClass($class);
            if ($rf->implementsInterface($reflectionClass->getName())) {
                return $this->get($rf->getName());
            }
        }
        throw new \Exception('cannot resolve interface');
    }

    public function configureSingleton($id)
    {
        $this->rules['shared'][] = $id;
        return $this;
    }

    public function configureInterface($interface, $class)
    {
        $this->rules['substitute'][$interface] = $class;
        return $this;
    }

    public function configureClass($class, array $params)
    {
        $this->rules[$class] = $params;
        return $this;
    }

    public static function make($class, array $arguments = [])
    {
        return self::getInstance()->get($class, $arguments);
    }

    public static function bind($abstract, $concrete = null)
    {
        return self::getInstance()->set($abstract, $concrete);
    }
}