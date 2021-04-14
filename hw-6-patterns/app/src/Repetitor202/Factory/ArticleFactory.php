<?php


namespace Repetitor202\Factory;

abstract class ArticleFactory
{
    abstract public function makeNews(string $title, string $body): News;

    abstract public function makeReview(string $title, string $body): Review;
}
