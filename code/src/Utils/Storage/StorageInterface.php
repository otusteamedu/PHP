<?php


namespace App\Utils\Storage;


interface StorageInterface
{
    public function save(string $name, string $data): void;
    public function get(string $name): string;
}
