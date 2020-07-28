<?php
namespace Ozycast\App\Core;

abstract class DTO
{
    public function __construct($data = [])
    {
        $this->serialize($data);
    }

    /**
     * @param array|object $data
     * @return DTO
     */
    public function serialize($data): DTO
    {
        if (empty($data))
            return $this;

        foreach ($data as $key => $param) {
            $method = "set".preg_replace("/_/", "", $key);
            if (method_exists($this, $method) && $param)
                $this->$method($param);
        }

        return $this;
    }

    /**
     * @param array $data
     * @return array
     */
    public function serializeAll(array $data): array
    {
        if (empty($datas))
            return [];

        $models = [];
        foreach ($data as $row) {
            $model = (new static)->serialize($row);
            $models[] = $model;
        }

        return $models;
    }
}