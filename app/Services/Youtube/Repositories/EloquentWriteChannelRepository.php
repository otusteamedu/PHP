<?php


namespace App\Services\Youtube\Repositories;


use App\Models\Channel;

class EloquentWriteChannelRepository implements WriteChannelRepository
{

    public function create(array $data): int
    {
        $qb = Channel::query();
        return $qb->create($data)->getAttribute('id');
    }

    public function update(int $id, array $data): void
    {
        Channel::whereId($id)->update($data);
    }

    public function delete(int $id): int
    {
        //Такой механизм требуется, чтобы сработал Oserver для канала на удаление.
        foreach (Channel::whereId($id)->get() as $channel) {
            return $channel->delete();
        }
    }
}
