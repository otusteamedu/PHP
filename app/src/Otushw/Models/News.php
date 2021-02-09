<?php


namespace Otushw\Models;

use Otushw\Article;
use Otushw\Visitor\Entity;
use Otushw\Visitor\Visitor;

/**
 * Class News
 *
 * @package Otushw\Models
 */
abstract class News extends Article implements Entity
{
    /**
     * @var string
     */
    protected string $event;

    /**
     * @return string
     */
    abstract public function getEvent(): string;

    /**
     * @param string $event
     */
    abstract public function setEvent(string $event): void;

    /**
     * @param Visitor $visitor
     */
    public function accept(Visitor $visitor): void
    {
        $visitor->visitNews($this);
    }

}