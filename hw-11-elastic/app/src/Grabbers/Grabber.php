<?php

namespace Grabbers;

interface Grabber
{
    public function grab (string $path): void;
}