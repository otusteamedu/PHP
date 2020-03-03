<?php

namespace Tirei01\Hw12\Storage;

class Property extends Category
{
    private string $type;
    private Category $category;

    public function __construct(
        int $id,
        string $name,
        string $type,
        Category $category,
        int $sort = 500,
        string $code = ''
    ) {
        parent::__construct($id, $name, $sort, $code);
        $this->setType($type);
        $this->setCategory($category);
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
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

    public static function getTypes()
    {
        return array(
            'text',
            'integer',
            'date',
            'bool',
            'float',
        );
    }
}