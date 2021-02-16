<?php


namespace Otushw\Storage;

use Otushw\Content;
use Otushw\ContentDTO;

interface MapperInterface
{
    public function findById(int $id): ?Content;
    public function insert(ContentDTO $content): Content;
    public function update(Content $content): bool;
    public function delete(Content $content): bool;
}