<?php


namespace App\Validator;


class BracesValidator extends AbstractValidator
{
    const BRACES_REGEX = '/^[()]*$/';
    private $key = 'braces';

    public function validate($value): bool
    {

        if (!preg_match(self::BRACES_REGEX, $value)) {
            $this->setError($this->key,'Wrong format');
            return false;
        }

        $length = strlen($value);

        if (0 === $length) {
            $this->setError($this->key,'Length == 0');
            return false;
        }

        $opened = [];
        $counter = 0;

        foreach (str_split($value) as $ch) {
            if ($ch === ')' && $counter === 0) {
                array_push($opened, 1);
                break;
            }

            if ($ch === '(') {
                array_push($opened, $ch);
            } elseif (array_pop($opened) !== '(') {
                array_push($opened, $ch);
            }

            $counter++;
        }

        if (count($opened) !== 0) {
            $this->setError($this->key,'Not closed');
            return false;
        }

        return true;
    }

    public function getErrors(): array
    {
        return $this->errors[$this->key] ?? [];
    }

}
