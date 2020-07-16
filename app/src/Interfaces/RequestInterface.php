<?php

namespace App\Interfaces;

interface RequestInterface
{
    public function getUrl();

    public function getMethod();

    public function getParameters();

    public function getQuery();

    public function setParameters($parameters);

    public function setQuery($query);
}