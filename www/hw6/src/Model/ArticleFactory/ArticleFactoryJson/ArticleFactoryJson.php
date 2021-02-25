<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\ArticleFactory\ArticleFactoryJson;

use Nlazarev\Hw6\Model\ArticleFactory\ArticleFactory;
use Nlazarev\Hw6\Model\ArticleFactory\IArticleFactory;
use Nlazarev\Hw6\Model\Article\News\INews;
use Nlazarev\Hw6\Model\Article\News\News;
use Nlazarev\Hw6\Model\Article\Review\IReview;
use Nlazarev\Hw6\Model\Article\Review\Review;
use Nlazarev\Hw6\Model\Wrapper\WrapperArticle\WrapperNews\WrapperNewsJson;
use Nlazarev\Hw6\Model\Wrapper\WrapperArticle\WrapperReview\WrapperReviewJson;

class ArticleFactoryJson extends ArticleFactory implements IArticleFactory
{
    public function createNews(string $header = "", string $main_text = "", string $source = ""): INews
    {
        return ($news = new News($header, $main_text, $source))
            ->setWrapper(new WrapperNewsJson($news));
    }

    public function createReview(string $header = "", string $main_text = "", int $rating = 1): IReview
    {
        return ($review = new Review($header, $main_text, $rating))
            ->setWrapper(new WrapperReviewJson($review));
    }
}
