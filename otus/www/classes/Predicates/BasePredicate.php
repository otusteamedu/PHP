<?php

namespace Classes\Predicates;

class BasePredicate
{
    protected $openBracket;
    protected $closeBracket;

    protected function isBracketsBalanceCorrect(string $string): bool
    {
        preg_match_all(sprintf('/\%s/', $this->openBracket), $string, $openBracket);
        preg_match_all(sprintf('/\%s/', $this->closeBracket), $string, $closedBracket);

        return count($openBracket[0]) === count($closedBracket[0]);
    }

    protected function isBracketsOrderCorrect(string $string, $openOffset = 0, $closeOffset = 0): bool
    {
        $openBracketPosition = strpos($string, $this->openBracket, $openOffset);
        $closeBracketPosition = strpos($string, $this->closeBracket, $closeOffset);

        if ($openBracketPosition === false && $closeBracketPosition === false) {
            return true;
        }

        if ($openBracketPosition > $closeBracketPosition) {
            return false;
        }

        return $this->isBracketsOrderCorrect($string, $openBracketPosition + 1, $closeBracketPosition + 1);
    }
}
