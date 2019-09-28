<?php

namespace App\Validator\Rules;

use App\Validator\{Rule, ValidationResult};

class NotEmptyRule extends Rule
{
    /** @var string */
    protected $name = 'not_empty';

    /**
     * @param array $data
     * @param string $key
     * @param array $params
     * @param array $messages
     * @return mixed
     */
    public function validate(array $data, string $key, array $params = [], array $messages = []): ValidationResult
    {
        $result = new ValidationResult();

        $result->isPassed = !empty($data[$key]);

        if ($result->failed()) {
            $result->message = $this->findMessage($messages, $key);
        }

        return $result;
    }
}
