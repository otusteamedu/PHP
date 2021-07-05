<?php


namespace App\Services\Youtube\Repositories;


use App\Models\Channel;

interface WriteChannelRepository
{
    public function create(array $data): int;
    public function update(int $id, array $data): void;
    public function delete(int $id): int;
}
