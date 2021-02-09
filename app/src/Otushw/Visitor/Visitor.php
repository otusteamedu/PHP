<?php


namespace Otushw\Visitor;

use Otushw\Models\News;
use Otushw\Models\Reviews;

/**
 * Interface Visitor
 *
 * @package Otushw\Visitor
 */
interface Visitor
{
    /**
     * @param News $news
     */
    public function visitNews(News $news): void;

    /**
     * @param Reviews $reviews
     */
    public function visitReviews(Reviews $reviews): void;
}