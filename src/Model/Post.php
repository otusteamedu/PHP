<?php

declare(strict_types=1);

namespace Otus\hw22\Model;

class Post extends BaseModel
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var int
     */
    private $author_id;

    /**
     * @var string
     */
    private $teaser;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $created_at;

    /**
     * @var string
     */
    private $updated_at;

    /**
     * @var int
     */
    private $is_published;

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
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return User
     */
    public function getAuthor(): ?User
    {
        return $this->related('author');
    }

    /**
     * @param User $author
     */
    public function setAuthor(User $author): void
    {
        $relation = $this->getRelation('author');

        if ($relation) {
            $relation->setResult($author);
        }

        $this->author_id = $author->getId();
    }

    /**
     * @return User
     */
    public function getComments(): ?array
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

    /**
     * @return int
     */
    public function getAuthorId(): int
    {
        return $this->author_id;
    }

    /**
     * @param int $authorId
     */
    public function setAuthorId(int $authorId): void
    {
        $this->author_id = $authorId;
    }

    /**
     * @return string
     */
    public function getTeaser(): string
    {
        return $this->teaser;
    }

    /**
     * @param string $teaser
     */
    public function setTeaser(?string $teaser): void
    {
        $this->teaser = $teaser;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->created_at = $createdAt;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    /**
     * @param string $updatedAt
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updated_at = $updatedAt;
    }

    /**
     * @return int
     */
    public function getIsPublished(): int
    {
        return $this->is_published;
    }

    /**
     * @param int $isPublished
     */
    public function setIsPublished(int $isPublished): void
    {
        $this->is_published = $isPublished;
    }
}