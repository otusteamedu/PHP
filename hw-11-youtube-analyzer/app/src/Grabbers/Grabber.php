<?php

namespace App\Grabbers;

interface Grabber
{
    public function grab (array $channelsList): void;
}