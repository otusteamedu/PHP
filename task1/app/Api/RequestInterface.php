<?php

namespace App\Api;

interface RequestInterface
{
    public function getQuery(string $attribute, ?string $default = null): string;

    public function getPost(string $attribute, ?string $default = null): string;
}