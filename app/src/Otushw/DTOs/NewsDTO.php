<?php


namespace Otushw\DTOs;


/**
 * Class NewsDTO
 *
 * @package Otushw\DTOs
 */
class NewsDTO
{
    /**
     * @var string
     */
    public string $title;

    /**
     * @var string
     */
    public string $body;

    /**
     * @var int
     */
    public int $created;

    /**
     * @var string
     */
    public string $event;
}