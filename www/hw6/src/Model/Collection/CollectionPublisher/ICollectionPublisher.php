<?php

declare(strict_types=1);

namespace Nlazarev\Hw6\Model\Collection\CollectionPublisher;

use SplSubject;

interface ICollectionPublisher
{
    public function add(SplSubject $publisher);
    public function rem(SplSubject $publisher);
    public function toArray(): array;
}
