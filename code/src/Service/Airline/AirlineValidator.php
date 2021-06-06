<?php


namespace App\Service\Airline;


use App\Utils\Validator\StringValidator;

class AirlineValidator
{
    const DESCRIPTION_LENGTH = 1000;
    const TITLE_MAX_LENGTH = 255;
    const TITLE_MIN_LENGTH = 3;
    const ABBREVIATION_LENGTH = 3;

    private string $error;
    private StringValidator $stringValidator;

    /**
     * AirlineValidator constructor.
     * @param \App\Utils\Validator\StringValidator $stringValidator
     */
    public function __construct(StringValidator $stringValidator)
    {
        $this->stringValidator = $stringValidator;
    }


    public function validate(?array $raw): bool
    {
        if (null === $raw) {
            $this->setError('data', 'empty data');
            return false;
        }

        if (!isset($raw['title']) || !$this->stringValidator->validate(
                $raw['title'],
                self::TITLE_MAX_LENGTH,
                self::TITLE_MIN_LENGTH
            )) {
            $this->setError('title', 'wrong length');
            return false;
        }

        if (!isset($raw['description']) || !$this->stringValidator->validate(
                $raw['description'],
                self::DESCRIPTION_LENGTH,
                self::TITLE_MIN_LENGTH
            )) {
            $this->setError('description', 'wrong length');
            return false;
        }

        if (!isset($raw['abbreviation']) || !$this->stringValidator->validate(
            $raw['abbreviation'],
            self::ABBREVIATION_LENGTH,
            self::ABBREVIATION_LENGTH
        )) {
            $this->setError('abbreviation', 'wrong length');
            return false;
        }

        return true;
    }

    public function getError(): ?string
    {
        return $this->error;
    }

    private function setError(string $key, string $message): void
    {
        $this->error = $key . ' ' . $message;
    }
}
