<?php


namespace App\Model;


interface SearchInterface
{
    public function getSearchIndex(): string;
    public function getSearchArray(): array;
}
