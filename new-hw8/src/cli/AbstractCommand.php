<?php


namespace AYakovlev\cli;


use AYakovlev\Exception\CliException;

abstract class AbstractCommand
{
    /** @var array */
    private array $params;

    public function __construct(array $params)
    {
        $this->params = $params;
        $this->checkParams();
    }

    abstract public function execute();

    abstract protected function checkParams();

    protected function getParam(string $paramName)
    {
        return $this->params[$paramName] ?? null;
    }

    protected function ensureParamExists(string $paramName)
    {
        if (!isset($this->params[$paramName])) {
            throw new CliException('Param with name "' . $paramName . '" is not set!');
        }
    }

}