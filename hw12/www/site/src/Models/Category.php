<?php


namespace App\Models;

use JsonSerializable;
use App\DB\Db;
use App\TableDataGateway\CategoryGateway;

class Category implements JsonSerializable
{
    private string $title;

    private int $id;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function jsonSerialize()
    {
        return [
            'id'  => $this->getId(),
            'title' => $this->getTitle(),
            'posts'=> $this->getPosts()
        ];
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getPosts()
    {
        if(!isset($this->posts)) {
            $reference = $this->getPostsReference();

            $this->posts = $reference;
        }
        return $this->posts;
    }

    public function getPostsReference()
    {
       $postGateway =  new CategoryGateway(Db::get());

       return $postGateway->getPosts($this);
    }

    public function setData(array $postData)
    {
        $this->setTitle($postData['title']);
    }
}