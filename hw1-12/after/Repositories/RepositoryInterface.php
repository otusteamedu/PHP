<?php

interface RepositoryInterface
{
    public function save($dto, $indexName): bool;
}