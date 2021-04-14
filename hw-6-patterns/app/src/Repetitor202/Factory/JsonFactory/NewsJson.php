<?php


namespace Repetitor202\Factory\JsonFactory;


use Repetitor202\Factory\Article;
use Repetitor202\Factory\News;

class NewsJson extends News
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
            "additional_info": "'. Article::CATEGORY_NEWS .':JsonFactoryBuild" ,
            "category": "'. Article::CATEGORY_NEWS .'" ,
            "title": "'. $this->title .'",
            "body": "'. $this->body .'"
        }';
    }

//    public function echoHtmlNews(string $title, string $body): string
//    {
//        return '{
//            "additional_info": "'. Article::CATEGORY_NEWS .':IEchoHtmlNews" ,
//            "category": "'. Article::CATEGORY_NEWS .'" ,
//            "title": "'. $title .'",
//            "body": "'. $body .'"
//        }';
//    }
}