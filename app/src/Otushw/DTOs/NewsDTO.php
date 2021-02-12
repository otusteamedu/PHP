<?php


namespace Otushw\DTOs;

class NewsDTO
{
    public string $title;

    public string $body;

    public int $created;

    public string $event;

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