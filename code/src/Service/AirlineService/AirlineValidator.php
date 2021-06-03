<?php


namespace App\Service\AirlineService;


class AirlineValidator
{
    const DESCRIPTION_LENGTH = 1000;
    const TITLE_LENGTH = 255;
    const ABBREVIATION_LENGTH = 3;
    const FIELDS = ['title', 'abbreviation', 'description'];

    private string $error;

    public function validate(?array $raw): bool
    {
        if (null === $raw) {
            $this->setError('data','empty data');
            return false;
        }

        foreach (self::FIELDS as $key) {
            if (!array_key_exists($key, $raw)) {
                $this->setError($key, 'not found');
                return false;
            }
        }

        if (! $this->validateStringField($raw, self::FIELDS[0], self::TITLE_LENGTH)) {
            return false;
        }

        if (! $this->validateStringField($raw, self::FIELDS[1], self::ABBREVIATION_LENGTH)) {
            return false;
        }

        if (! $this->validateStringField($raw, self::FIELDS[2], self::DESCRIPTION_LENGTH)) {
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

    private function validateStringField(array $data, string $field, int $length): bool
    {
        $strLength = strlen($data[$field]);

        if ($strLength === 0) {
            $this->setError($field, 'length 0');
            return false;
        }

        if ($strLength > $length) {
            $this->setError($field, 'max length ' . $length);
            return false;
        }

        return true;
    }

}
