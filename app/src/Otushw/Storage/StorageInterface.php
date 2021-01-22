<?php


namespace Otushw\Storage;

use Otushw\EventDTO;
use Otushw\UserRequestDTO;

interface StorageInterface
{
    public function find(UserRequestDTO $userRequest): ?EventDTO;
    public function set(EventDTO $event): bool;
    public function delete(): bool;
}