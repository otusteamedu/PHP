<?php


namespace Otushw\Visitor;

use Otushw\Factory\News;
use Otushw\Factory\Reviews;

interface Visitor
{
    public function visitNews(News $news): void;

    public function visitReviews(Reviews $reviews): void;
}