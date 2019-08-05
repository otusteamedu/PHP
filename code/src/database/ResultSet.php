<?php

namespace crazydope\theater\database;

use ArrayObject;

class ResultSet extends AbstractResultSet
{
    public const TYPE_ARRAYOBJECT = 'arrayobject';
    public const TYPE_ARRAY = 'array';
    /**
     * Allowed return types
     *
     * @var array
     */
    protected $allowedReturnTypes = [
        self::TYPE_ARRAYOBJECT,
        self::TYPE_ARRAY,
    ];
    /**
     * @var ArrayObject
     */
    protected $arrayObjectPrototype;
    /**
     * @var string
     */
    protected $returnType = self::TYPE_ARRAYOBJECT;

    /**
     * Constructor
     *
     * @param null|ArrayObject $arrayObjectPrototype
     * @param string $returnType
     */
    public function __construct($arrayObjectPrototype = null, $returnType = self::TYPE_ARRAYOBJECT)
    {
        if (in_array($returnType, [self::TYPE_ARRAY, self::TYPE_ARRAYOBJECT], false)) {
            $this->returnType = $returnType;
        } else {
            $this->returnType = self::TYPE_ARRAYOBJECT;
        }
        if ($this->returnType === self::TYPE_ARRAYOBJECT) {
            $this->setArrayObjectPrototype($arrayObjectPrototype ?: new ArrayObject([], ArrayObject::ARRAY_AS_PROPS));
        }
    }

    /**
     * @param $arrayObjectPrototype
     * @return ResultSet
     */
    public function setArrayObjectPrototype($arrayObjectPrototype): self
    {
        if (!is_object($arrayObjectPrototype)
            || (
                !$arrayObjectPrototype instanceof ArrayObject
                && !method_exists($arrayObjectPrototype, 'exchangeArray')
            )
        ) {
            throw new \InvalidArgumentException(
                'Object must be of type ArrayObject, or at least implement exchangeArray'
            );
        }
        $this->arrayObjectPrototype = $arrayObjectPrototype;
        return $this;
    }

    /**
     * @return ArrayObject
     */
    public function getArrayObjectPrototype(): ArrayObject
    {
        return $this->arrayObjectPrototype;
    }

    /**
     * @return string
     */
    public function getReturnType(): string
    {
        return $this->returnType;
    }

    /**
     * @return array|ArrayObject|null
     */
    public function current()
    {
        $data = parent::current();
        if ($this->returnType === self::TYPE_ARRAYOBJECT && is_array($data)) {
            // $ao ArrayObject
            $ao = clone $this->arrayObjectPrototype;
            if ($ao instanceof ArrayObject || method_exists($ao, 'exchangeArray')) {
                $ao->exchangeArray($data);
            }
            return $ao;
        }
        return $data;
    }
}