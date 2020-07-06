<?php

namespace App\Stories;

interface Story
{
    public function execute($data = null);
}