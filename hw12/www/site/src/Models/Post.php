<?php


namespace App\Models;


use JsonSerializable;

class Post implements JsonSerializable
{
    private string $title;

    private string $text;

    private int $id;

    private int $category_id;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function setCategory(int $categoryId): void
    {
        $this->category_id = $categoryId;
    }

    public function getCategory(): int
    {
        return $this->category_id;
    }


    public function jsonSerialize()
    {
        return [
            'id'  => $this->getId(),
            'title' => $this->getTitle(),
            'text' => $this->getText(),
            'category_id' => $this->getCategory()
        ];
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function setData(array $postData)
    {
        $this->setTitle($postData['title']);
        $this->setText($postData['text']);
        $this->setCategory($postData['category_id']);
    }
}