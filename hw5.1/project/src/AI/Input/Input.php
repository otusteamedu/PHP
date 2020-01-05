<?php


namespace AI\backend_php_hw5_1\Input;


abstract class Input
{
    /**
     * @var array
     */
    protected array $params;

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}