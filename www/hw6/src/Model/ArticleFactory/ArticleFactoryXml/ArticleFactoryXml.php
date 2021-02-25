<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\ArticleFactory\ArticleFactoryXml;

use Nlazarev\Hw6\Model\ArticleFactory\IArticleFactory;
use Nlazarev\Hw6\Model\Article\News\INews;
use Nlazarev\Hw6\Model\Article\News\News;
use Nlazarev\Hw6\Model\Article\Review\IReview;
use Nlazarev\Hw6\Model\Article\Review\Review;
use Nlazarev\Hw6\Model\Wrapper\WrapperArticle\WrapperNews\WrapperNewsXml;
use Nlazarev\Hw6\Model\Wrapper\WrapperArticle\WrapperReview\WrapperReviewXml;
use Nlazarev\Hw6\Model\ArticleFactory\ArticleFactory;

class ArticleFactoryXml extends ArticleFactory implements IArticleFactory
{
    public function createNews(string $header = "", string $main_text = "", string $source = ""): INews
    {
        return ($news = new News($header, $main_text, $source))
            ->setWrapper(new WrapperNewsXml($news));
    }

    public function createReview(string $header = "", string $main_text = "", int $rating = 1): IReview
    {
        return ($review = new Review($header, $main_text, $rating))
            ->setWrapper(new WrapperReviewXml($review));
    }
}
