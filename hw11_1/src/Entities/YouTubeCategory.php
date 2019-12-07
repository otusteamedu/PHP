<?php

declare(strict_types=1);

namespace App\Entities;

class YouTubeCategory
{
    /**
     * @var string
     */
    protected $id;
    /**
     * @var string
     */
    protected $title;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return YouTubeCategory
     */
    public function setId(string $id): YouTubeCategory
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return YouTubeCategory
     */
    public function setTitle(string $title): YouTubeCategory
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param array $data
     * @return YouTubeCategory
     */
    public static function fromArray(array $data): YouTubeCategory
    {
        $category = new YouTubeCategory;

        foreach ($data as $key => $value) {
            $setterName = 'set' . ucfirst($key);
            if (method_exists($category, $setterName)) {
                $category->{$setterName}($value);
            }
        }

        return $category;
    }
}
