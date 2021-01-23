<?php


namespace Otushw\Storage;

use Otushw\Content;

interface StorageInterface
{
    public function findById(int $id): ?Content;
    public function insert(Content $content): Content;
    public function update(Content $content): bool;
    public function delete(Content $content): bool;
}