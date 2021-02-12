<?php


namespace Otushw\Factory;

use Otushw\Visitor\Visitor;

abstract class News implements Article
{
    public function accept(Visitor $visitor): void
    {
        $visitor->visitNews($this);
    }

    abstract public function getEvent(): string;
    abstract public function setEvent(string $event): void;
}