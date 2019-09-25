<?php

namespace App\Validator;

abstract class Rule
{
    /** @var string */
    protected $name;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param array $data
     * @param string $key
     * @param array $params
     * @param array $messages
     * @return ValidationResult
     */
    abstract public function validate(array $data, string $key, array $params = [], array $messages = []): ValidationResult;

    /**
     * @param array $messages
     * @param string $key
     * @return string|null
     */
    protected function findMessage(array $messages, string $key): ?string
    {
        if (array_key_exists($messageKey = "{$key}.{$this->name}", $messages)) {
            return $messages[$messageKey];
        }

        return null;
    }
}
