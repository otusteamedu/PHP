<?php

namespace App\Validator\Rules;

use App\Validator\{Rule, ValidationResult};

class MinRule extends Rule
{
    /** @var string */
    protected $name = 'min';

    /**
     * @param array $data
     * @param string $key
     * @param array $params
     * @param array $messages
     * @return ValidationResult
     */
    public function validate(array $data, string $key, array $params = [], array $messages = []): ValidationResult
    {
        if (empty($params)) {
            throw new \InvalidArgumentException('Min Rule: parameter required');
        }

        $result = new ValidationResult();

        $param = intval($params[0]);

        $result->isPassed = strlen($data[$key]) >= $param;

        if ($result->failed()) {
            $result->message = str_replace(
                ':min',
                $param,
                $this->findMessage($messages, $key)
            );
        }

        return $result;
    }
}
