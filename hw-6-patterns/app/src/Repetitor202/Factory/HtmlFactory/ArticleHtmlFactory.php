<?php


namespace Repetitor202\Factory\HtmlFactory;

use Repetitor202\Factory\ArticleFactory;

class ArticleHtmlFactory extends ArticleFactory
{
    public function makeNews(string $title, string $body): NewsHtml
    {
        return new NewsHtml($title, $body);
    }

    public function makeReview(string $title, string $body): ReviewHtml
    {
        return new ReviewHtml($title, $body);
    }
}