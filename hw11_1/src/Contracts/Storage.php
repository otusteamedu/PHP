<?php

namespace App\Contracts;

use App\Entities\YouTubeChannel;

interface Storage
{
    /**
     * @return YouTubeChannel[]
     */
    public function getAll(): array;

    /**
     * @param $id
     * @return YouTubeChannel|null
     */
    public function getById($id): ?YouTubeChannel;

    /**
     * @param array $data
     * @return mixed
     */
    public function insert(array $data);

    /**
     * @param array $data
     * @return mixed
     */
    public function update(array $data);

    /**
     * @param array $data
     * @return mixed
     */
    public function delete(array $data);
}
