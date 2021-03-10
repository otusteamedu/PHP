<?php


namespace Otushw;

use Otushw\Exception\AppException;

class Params
{

    private array $params;

    public function __construct()
    {
        $this->validate();
        $this->params = $this->load();
    }

    private function validate(): void
    {
        $this->checkRequest();
    }

    private function checkRequest(): void
    {
        if (empty($_POST)) {
            throw new AppException('Input date is empty');
        }
        $this->checkRequestParams();
    }

    private function checkRequestParams()
    {
        foreach ($_ENV['request'] as $varName => $varType) {
            if (!$this->isExistParam($varName)) {
                throw new AppException('Key "' . $varName . '" is missing.');
            }
            if (!$this->checkTypeParam($varName, $varType)) {
                throw new AppException('Param "$paramName" type does not match.');
            }
        }
    }

    private function isExistParam(string $paramName): bool
    {
        return !empty($_POST[$paramName]);
    }

    private function checkTypeParam(string $paramName, string $paramType): bool
    {
        $func = 'is_' . $paramType;
        if (!function_exists($func)) {
            throw new AppException('Param "$paramName" has not scalar value.');
        }
        return $func($_POST[$paramName]);
    }

    private function load(): array
    {
        $data = [];
        foreach ($_ENV['request'] as $varName => $varType) {
            if (!empty($_POST[$varName])) {
                $data[$varName] = $_POST[$varName];
            }
        }

        return $data;
    }

    public function get(): array
    {
        return $this->params;
    }

    public function getJSON(): string
    {
        return json_encode($this->params);
    }

}
