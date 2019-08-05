<?php

declare(strict_types=1);

namespace app\Channel;

use app\Channel;

class Collection
{
    /**
     * @var array
     */
    private $items = [];


    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function addChannel(Channel $channel): void
    {
        $this->items[$channel->getId()] = $channel;
    }

    public function addChannels(array $items = []): void
    {
        foreach ($items as $item) {
            if (!($item instanceof Channel)) {
                throw new \InvalidArgumentException("Item must be instance of class app\Channel");
            }
            $this->addChannel($item);
        }
    }

    public function getChannel(string $id): ?Channel
    {
        return $this->items[$id] ?? null;
    }

    public function getChannels(): array
    {
        return $this->items;
    }
}
