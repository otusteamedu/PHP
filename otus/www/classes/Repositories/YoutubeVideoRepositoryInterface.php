<?php


namespace Classes\Repositories;


use Classes\Models\YoutubeVideo;

interface YoutubeVideoRepositoryInterface
{

    public function create(YoutubeVideo $youtubeVideoModel);

    public function deleteById(string $id);
}
