<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Collection\CollectionPublisher;

use SplSubject;

class CollectionPublisher implements ICollectionPublisher
{
    private array $publishers;

    public function __construct(SplSubject ...$publishers)
    {
        $this->publishers = $publishers;
    }

    public function add(SplSubject $publisher)
    {
        $this->publishers[] = $publisher;

        return $this;
    }

    public function rem(SplSubject $publisher)
    {
        foreach ($this->publishers as $key => $value) {
            if ($value === $publisher) {
                unset($this->publishers[$key]);
            }
        }

        return $this;
    }

    public function toArray(): array
    {
        return $this->publishers;
    }
}
