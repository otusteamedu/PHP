<?php

namespace App\Validator\Rules;

use App\Validator\{Rule, ValidationResult};

class MatchCountsRule extends Rule
{
    /** @var string */
    protected $name = 'match_counts';

    /**
     * @param array $data
     * @param string $key
     * @param array $params
     * @param array $messages
     * @return ValidationResult
     */
    public function validate(array $data, string $key, array $params = [], array $messages = []): ValidationResult
    {
        if (count($params) < 2) {
            throw new \InvalidArgumentException('Match Counts rule: too few parameters.');
        }

        $firstCount = substr_count($data[$key], $params[0]);
        $secondCount = substr_count($data[$key], $params[1]);

        $result = new ValidationResult();

        $result->isPassed = $firstCount === $secondCount;

        if ($result->failed()) {
            $message = str_replace(':first_param', $params[0], $this->findMessage($messages, $key));
            $message = str_replace(':second_param', $params[1], $message);
            $result->message = $message;
        }

        return $result;
    }
}
