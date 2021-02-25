<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\ArticleFactory;

use Nlazarev\Hw6\Model\Article\News\INews;
use Nlazarev\Hw6\Model\Article\Review\IReview;

abstract class ArticleFactory implements IArticleFactory
{
    private static IArticleFactory $instance;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): IArticleFactory
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }
    
    abstract public function createNews(string $header = "", string $main_text = "", string $source = ""): INews;
    abstract public function createReview(string $header = "", string $main_text = "", int $rating = 1): IReview;
}
