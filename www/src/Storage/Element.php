<?php

namespace Tirei01\Hw12\Storage;

use Tirei01\Hw12\DomainObject;

class Element extends DomainObject
{
    private Category $category;
    private string $name;
    private int $sort;
    private string $code;

    public function __construct(int $id, string $name, Category $category, int $sort = 500, string $code = '')
    {
        $this->setId($id);
        $this->setName($name);
        $this->setCategory($category);
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

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

}