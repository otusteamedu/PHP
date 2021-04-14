<?php


namespace Repetitor202\Visitor;

interface IArticleVisitable
{
    public function accept(IArticleOperationVisitor $iArticleOperationVisitor): void;
}