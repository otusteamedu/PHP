<?php


namespace App\Validator;


class BracesValidator extends AbstractValidator
{
    private string $regex = '/^[()]*$/';

    public function validate($value): bool
    {
        $this->errors = [];

        if (!preg_match($this->regex, $value)) {
            $this->setError('Wrong format');
            return false;
        }

        $length = strlen($value);

        if (0 === $length) {
            $this->setError('Length == 0');
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
            $this->setError('Not closed');
            return false;
        }

        return true;
    }


}
