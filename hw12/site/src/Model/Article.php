<?php


namespace AYakovlev\Model;


class Article extends ActiveRecordEntity
{
    protected string $name;
    protected string $text;
    protected int $authorId;
    protected ?string $createdAt = null;

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function setAuthor(User $author): void
    {
        $this->authorId = $author->getId();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getAuthorId(): int
    {
        return (int) $this->authorId;
    }

    protected static function getTableName(): string
    {
        return 'articles';
    }

    // Lazy load - запрос будет выполнен только если мы вызовем этот геттер.
    public function getAuthor(): User
    {
        return User::getById($this->authorId);
    }

}
