<?php

declare(strict_types=1);

namespace App\Model\Video\UseCase\Update;

class UpdateVideoCommand
{

    public string $id;
    public string $title;
    public int    $likeCount;
    public int    $dislikeCount;

    public function __construct(string $id, string $title)
    {
        $this->id = $id;
        $this->title = $title;
    }

}