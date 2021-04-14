<?php


namespace Repetitor202\Factory\JsonFactory;


use Repetitor202\Factory\ArticleFactory;


class ArticleJsonFactory extends ArticleFactory
{
    public function makeNews(string $title, string $body): NewsJson
    {
        return new NewsJson($title, $body);
    }

    public function makeReview(string $title, string $body): ReviewJson
    {
        return new ReviewJson($title, $body);
    }
}