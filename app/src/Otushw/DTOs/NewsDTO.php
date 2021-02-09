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

    /**
     * NewsDTO constructor.
     *
     * @param string $title
     * @param string $body
     * @param int    $created
     * @param string $event
     */
    public function __construct(
        string $title,
        string $body,
        int $created,
        string $event
    ) {
        $this->title = $title;
        $this->body = $body;
        $this->created = $created;
        $this->event = $event;
    }

}