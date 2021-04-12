<?php

declare(strict_types=1);

namespace App\Model\Channel\UseCase\Update;

class UpdateChannelCommand
{

    public string $id;
    public string $title;

    public function __construct(string $id, string $title)
    {
        $this->id = $id;
        $this->title = $title;
    }

}