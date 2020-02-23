<?php

namespace App\Kernel;

class Request implements RequestInterface
{
    private $storage;
    private $uri;
    private $entity;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = $_SERVER['REQUEST_URI'];
        $uriMatcher = explode('/', $this->uri);

        try {
            $this->entity = ucwords($uriMatcher[1]);
        }
        catch (\Exception $e) {
            'Entity don\'t choose';
        }

        $this->storage = $this->cleanInput($_REQUEST);
    }

    /**
     * @param $data
     * @return array|string
     */
    private function cleanInput($data) {
        if (is_array($data)) {
            $cleaned = [];
            foreach ($data as $key => $value) {
                $cleaned[$key] = $this->cleanInput($value);
            }
            return $cleaned;
        }
        return trim(htmlspecialchars($data, ENT_QUOTES));
    }


    /**
     * @param string $key
     * @return string
     */
    public function get(string $key): string
    {
        if (isset($this->storage[$key])) return $this->storage[$key];
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $result = [];
        foreach ($this->storage as $argName => $argValue) {
            if ($argName == 'uri') {
                continue;
            }

            $result[$argName] = $argValue;
        }

        return $result;
    }

    /**
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param mixed $entity
     */
    public function setEntity($entity): void
    {
        $this->entity = $entity;
    }
}