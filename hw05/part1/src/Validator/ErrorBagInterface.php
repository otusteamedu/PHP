<?php

namespace App\Validator;

interface ErrorBagInterface
{
    /**
     * @param string $key
     * @param string $value
     * @return ErrorBagInterface
     */
    public function add(string $key, string $value): ErrorBagInterface;

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * @return array
     */
    public function all(): array;

    /**
     * @param string $key
     * @return string|null
     */
    public function first(string $key): ?string;

    public function clearAll(): void;

    /**
     * @param string|null $key
     * @return bool
     */
    public function isEmpty(?string $key): bool;

    /**
     * @param string|null $key
     * @return bool
     */
    public function isNotEmpty(?string $key): bool;
}
