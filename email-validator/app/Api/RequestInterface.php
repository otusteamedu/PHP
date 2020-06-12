<?php

namespace App\Api;

interface RequestInterface
{
    /**
     * @param string $attribute
     * @param string|null $default
     * @return array|string|null
     */
    public function getQuery(string $attribute, ?string $default = null);

    /**
     * @param string $attribute
     * @param string|null $default
     * @return array|string|null
     */
    public function getPost(string $attribute, ?string $default = null);
}