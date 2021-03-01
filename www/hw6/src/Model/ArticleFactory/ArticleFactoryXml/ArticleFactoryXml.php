<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\ArticleFactory\ArticleFactoryXml;

use Nlazarev\Hw6\Model\ArticleContent\NewsContent\INewsContent;
use Nlazarev\Hw6\Model\ArticleContent\NewsContent\NewsContent;
use Nlazarev\Hw6\Model\ArticleContent\ReviewContent\IReviewContent;
use Nlazarev\Hw6\Model\ArticleContent\ReviewContent\ReviewContent;
use Nlazarev\Hw6\Model\ArticleFactory\ArticleFactory;
use Nlazarev\Hw6\Model\ArticleFactory\IArticleFactory;
use Nlazarev\Hw6\Model\Article\News\News;
use Nlazarev\Hw6\Model\Article\Review\Review;
use Nlazarev\Hw6\Model\Wrapper\WrapperArticle\WrapperNews\WrapperNewsXml;
use Nlazarev\Hw6\Model\Wrapper\WrapperArticle\WrapperReview\WrapperReviewXml;

class ArticleFactoryXml extends ArticleFactory implements IArticleFactory
{
    public function createNewsContent(string $header = "", string $main_text = "", string $source = ""): INewsContent
    {
        return new NewsContent($news = new News($header, $main_text, $source), new WrapperNewsXml($news));
    }

    public function createReviewContent(string $header = "", string $main_text = "", int $rating = 1): IReviewContent
    {
        return new ReviewContent($review = new Review($header, $main_text, $rating), new WrapperReviewXml($review));
    }
}
