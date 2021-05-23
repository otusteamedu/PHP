<?php

namespace CodeArchitecture\After\Query;

interface QueryBuilderInterface
{
    /**
     * @return string
     */
    public function createQuery(): string;
}
