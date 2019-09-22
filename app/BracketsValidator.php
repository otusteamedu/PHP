<?php


class BracketsValidator
{
    protected $string;

    public function __construct(string $string)
    {
        $this->string = $string;
    }

    public function validate() {
        if (!empty($this->string)) {
            $brackets = str_split($this->string);
            $counter = 0;
            foreach ($brackets as $bracket) {
                if ($bracket === '(') {
                    $counter++;
                } elseif ($bracket === ')') {
                    $counter--;
                }
            }
            return $counter === 0;
        }
        return false;
    }
}