<?php

declare(strict_types=1);

namespace App\Service\YouTube\Dto;

class ChannelDto
{

    public string $id;
    public string $title;

    public function __construct(string $id, string $title)
    {
        $this->id = $id;
        $this->title = $title;
    }

}