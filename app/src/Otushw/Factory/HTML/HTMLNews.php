<?php


namespace Otushw\Factory\HTML;

use Otushw\DTOs\NewsDTO;
use Otushw\Factory\News;
use Otushw\Factory\Render;

class HTMLNews extends News
{
    private string $title;
    private string $body;
    private string $event;
    private int $created;
    private Render $render;

    public function __construct(NewsDTO $raw)
    {
        $this->title = $raw->title;
        $this->body = $raw->body;
        $this->event = $raw->event;
        $this->created = $raw->created;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function getEvent(): string
    {
        return $this->event;
    }

    public function setEvent(string $event): void
    {
        $this->event = $event;
    }

    public function getCreated(): int
    {
        return $this->created;
    }

    public function setCreated(int $created): void
    {
        $this->created = $created;
    }

    public function setRender(Render $render): void
    {
        $this->render = $render;
    }

    public function render(): void
    {
        $this->render->render($this);
    }


}