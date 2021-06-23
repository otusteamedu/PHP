<?php

declare(strict_types=1);

namespace App\Service\Hydrator;

interface HydratorInterface
{
    public function hydrate($entityOrEntityClassName, array $data): object;

    public function hydrateProperty(object $targetEntity, string $propertyName, $value): object;
}
