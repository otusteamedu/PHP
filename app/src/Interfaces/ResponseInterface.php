<?php

namespace App\Interfaces;

interface ResponseInterface
{
    public function getStatusCode();

    public function getHeaders();

    public function getContent();

    public function getVersion();
}