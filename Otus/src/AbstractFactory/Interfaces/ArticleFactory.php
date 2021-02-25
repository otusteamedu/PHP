<?php


namespace Otus\AbstractFactory\Interfaces;


interface ArticleFactory
{
    public function createNews(): News;
    public function createReview(): Review;
}