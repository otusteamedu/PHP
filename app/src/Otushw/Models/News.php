<?php


namespace Otushw\Models;

use Otushw\Article;
use Otushw\DTOs\NewsDTO;
use Otushw\Visitor\Entity;
use Otushw\Visitor\Visitor;

class News extends Article implements Entity
{
    protected string $event;

    public function __construct(NewsDTO $raw)
    {
        $this->setTitle($raw->title);
        $this->setBody($raw->body);
        $this->setCreated($raw->created);
        $this->setEvent($raw->event);
    }

    public function getEvent(): string
    {
        return $this->event;
    }

    public function setEvent(string $event): void
    {
        $this->event = $event;
    }

    public function accept(Visitor $visitor): void
    {
        $visitor->visitNews($this);
    }

}