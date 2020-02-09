<?php

namespace Entity\Filter;

interface IFilters
{
    public function build(array $row);

    public function fetch(): array;
}