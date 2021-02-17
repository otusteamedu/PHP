<?php

namespace Otus\Storage;

use Otus\DTO\EventDTO;
use Otus\DTO\UserRequestDTO;

interface StorageInterface
{
    public function save(EventDTO $event);
    public function find(UserRequestDTO $userRequestDTO): ?EventDTO;
}