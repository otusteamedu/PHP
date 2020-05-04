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
            $method = "set".$key;
            if (method_exists($this, $method))
                $this->$method($data[$key]);
        }

        return $this;
    }

    /**
     * @param array $datas
     * @return array
     */
    public function serializeAll(array $datas): array
    {
        if (empty($datas))
            return [];

        $models = [];
        foreach ($datas as $data) {
            $model = (new static)->serialize($data);
            $models[] = $model;
        }

        return $models;
    }
}