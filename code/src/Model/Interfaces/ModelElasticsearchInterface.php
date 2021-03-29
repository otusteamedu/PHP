<?php

namespace App\Model\Interfaces;


interface ModelElasticsearchInterface
{
    public function getId(): string;
    public function getSearchIndex(): string;
    public function getSearchArray(): array;
    public function getSearchFields(): array;
    public function getBuilder(): BuilderElasticsearchInterface;
}
