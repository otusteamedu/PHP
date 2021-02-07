<?php


namespace Otushw\Models;

use Otushw\Article;

/**
 * Class News
 *
 * @package Otushw\Models
 */
abstract class News extends Article
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
}