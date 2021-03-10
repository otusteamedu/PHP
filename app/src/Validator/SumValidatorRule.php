<?php


namespace Otus\Validator;


use Rakit\Validation\Rule;

class SumValidatorRule extends Rule
{
    protected $fillableParams = ['min', 'max'];

    public function check($value): bool
    {

        $min = $this->parameter('min');
        $max = $this->parameter('max');

        $sum = floatval(str_replace(',', '.', str_replace('.', '', $value)));

        if ($sum < 1 or ($max and $sum >= $max) or ($min and $sum <= $min)) {
            return false;
        }

        return true;
    }
}