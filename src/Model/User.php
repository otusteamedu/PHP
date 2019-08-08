<?php

declare(strict_types=1);

namespace Otus\hw22\Model;

class User extends BaseModel
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
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

    /**
     * @return array
     */
    public function getPosts(): array
    {
        return $this->related('posts');
    }

    /**
     * @param array $posts
     */
    public function setPosts(array $posts): void
    {
        $relation = $this->getRelation('posts');

        if ($relation) {
            $relation->setResult($posts);
        }
    }

    /**
     * @return array
     */
    public function getComments(): array
    {
        return $this->related('comments');
    }

    /**
     * @param array $comments
     */
    public function setComments(array $comments): void
    {
        $relation = $this->getRelation('comments');

        if ($relation) {
            $relation->setResult($comments);
        }
    }

}