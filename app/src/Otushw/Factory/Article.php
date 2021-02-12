<?php


namespace Otushw\Factory;

use Otushw\Visitor\Entity;

interface Article extends Entity
{
    public function getTitle(): string;
    public function setTitle(string $title): void;
    public function getBody(): string;
    public function setBody(string $body): void;
    public function getCreated(): int;
    public function setCreated(int $created): void;

    public function render(): void;
    public function setRender(Render $render): void;
}