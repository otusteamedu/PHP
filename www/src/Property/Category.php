<?php
namespace Tirei01\Hw12\Property;
use Tirei01\Hw12\DomainObject;

class Category extends DomainObject
{
    private int $sort;
    private string $code;

    public function __construct(int $id, string $name, int $sort = 500, string $code = '')
    {
        $this->setId($id);
        $this->setName($name);
        $this->setSort($sort);
        $this->setCode($code);
    }

    /**
     * @return int
     */
    public function getSort(): int
    {
        return $this->sort;
    }

    /**
     * @param int $sort
     */
    public function setSort(int $sort): void
    {
        $this->sort = $sort;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }
}