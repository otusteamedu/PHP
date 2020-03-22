<?php
namespace Otus\HW11\Task2;

class Param
{
    protected $paramName;

    protected $paramValue;

    /**
     * Extract param from string 'paramName=paramVal'
     *
     * Param constructor.
     * @param string $strParam
     */
    public function __construct(string $strParam)
    {
        $arTmp = explode('=', $strParam);
        $this->paramName = $arTmp[0];
        $this->paramValue = $arTmp[1];
    }

    public function getName(): string
    {
        return $this->paramName;
    }


    public function getValue()
    {
        return $this->paramValue;
    }
}