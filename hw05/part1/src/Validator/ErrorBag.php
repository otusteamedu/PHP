<?php

namespace App\Validator;

class ErrorBag
{
    /** @var array */
    protected $errors = [];

    /**
     * @param string $key
     * @param string $value
     * @return ErrorBag
     */
    public function add(string $key, string $value): ErrorBag
    {
        $this->errors[$key][] = $value;

        return $this;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->errors);
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->errors;
    }

    /**
     * @param string $key
     * @return string|null
     */
    public function first(string $key): ?string
    {
        if (array_key_exists($key, $this->errors) && $this->isNotEmpty($key)) {
            return $this->errors[$key][0];
        }

        return null;
    }

    public function clearAll(): void
    {
        $this->errors = [];
    }

    /**
     * @param string|null $key
     * @return bool
     */
    public function isEmpty(?string $key): bool
    {
        if ($key) {
            return empty($this->errors[$key]);
        }

        return empty($this->errors);
    }

    /**
     * @param string|null $key
     * @return bool
     */
    public function isNotEmpty(?string $key): bool
    {
        return !$this->isEmpty($key);
    }
}
