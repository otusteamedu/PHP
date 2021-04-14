<?php


namespace Repetitor202\Factory\JsonFactory;


use Repetitor202\Factory\Article;
use Repetitor202\Factory\Review;

class ReviewJson extends Review
{
    public function __construct(string $title, string $body)
    {
        $this->setTitle($title);
        $this->setBody($body);
        $this->setFactoryBuild();
    }

    public function setFactoryBuild(): void
    {
        $this->factoryBuild = '{
            "additional_info": "'. Article::CATEGORY_REVIEW .':JsonFactoryBuild" ,
            "category": "'. Article::CATEGORY_REVIEW .'" ,
            "title": "'. $this->title .'",
            "body": "'. $this->body .'"
        }';
    }
}