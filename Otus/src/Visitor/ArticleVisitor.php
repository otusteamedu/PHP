<?php
namespace Otus\Visitor\Interfaces;

interface ArticleVisitor
{
    public function visitReview();
    public function visitNews();
}