<?php

namespace Grabbers;

interface Grabber
{
    public function grab (array $channelsList): void;
}