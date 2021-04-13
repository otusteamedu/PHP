<?php

declare(strict_types=1);

namespace App\Model\Channel\UseCase\Add;

class AddChannelCommand
{

    public string $id;
    public string $title;

    public function __construct(string $id, string $title)
    {
        $this->id = $id;
        $this->title = $title;
    }

}