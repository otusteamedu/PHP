<?php


namespace App\Services\Youtube\Repositories;


use App\Models\Video;

class EloquentWriteVideoRepository implements WriteVideoRepository
{

    public function create(array $data): int
    {
        $qb = Video::query();
        return $qb->create($data)->getAttribute('id');
    }

    public function update(int $id, array $data): void
    {
        Video::whereId($id)->update($data);
    }

    public function delete(int $id): int
    {
        //Такой механизм требуется, чтобы сработал Oserver для Видео на удаление.
        foreach (Video::whereId($id)->get() as $video) {
            return $video->delete();
        }
    }
}
