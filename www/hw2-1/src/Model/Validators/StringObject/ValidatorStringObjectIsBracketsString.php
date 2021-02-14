<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\Validators\StringObject;

use Nlazarev\Hw2_1\Model\General\String\IStringObject;

final class ValidatorStringObjectIsBracketsString extends ValidatorStringObject implements IValidatorStringObjectIsBracketsString
{
    protected IStringObject $string_object;
    protected $brackets_symbols = array("open" => "(", "close" => ")");

    protected function isLengthEven(): bool
    {
        $len = $this->string_object->getLength();

        if ($len % 2 == 0) {
            return true;
        }

        return false;
    }

    protected function isCorrectSymbols(): bool
    {
        $len = $this->string_object->getLength();
        $str = $this->string_object->getValue();

        for ($pos = 0; $pos < $len; $pos++) {
            if (!in_array($str[$pos], $this->brackets_symbols)) {
                return false;
            }
        }

        return true;
    }

    protected function isOpenEqualClose(): bool
    {
        $len = $this->string_object->getLength();
        $str = $this->string_object->getValue();

        $count_open = 0;

        for ($pos = 0; $pos < $len; $pos++) {
            if ($str[$pos] == $this->brackets_symbols["open"]) {
                $count_open++;
            }
        }

        if ($count_open == $len - $count_open) {
            return true;
        }

        return false;
    }

    protected function isBalanced(int $pos = 0, int $balance = 0): bool
    {
        if ($balance < 0) {
            return false;
        }

        $len = $this->string_object->getLength();
        $str = $this->string_object->getValue();
        $open = $this->brackets_symbols["open"];
        $close = $this->brackets_symbols["close"];

        while ($pos < $len) {
            if ($str[$pos] == $open) {
                return $this->isBalanced(++$pos, ++$balance);
            } elseif ($str[$pos] == $close) {
                return $this->isBalanced(++$pos, --$balance);
            } else {
                return false;
            }
        }

        return ($balance == 0);
    }


    public function isStringObjectBalancedBracketsString(IStringObject $string_object): bool
    {
        if (!parent::isValidStringObject($string_object)) {
            return false;
        }

        $this->string_object = $string_object;

        if (!$this->isLengthEven()) {
            return false;
        }

        if (!$this->isCorrectSymbols()) {
            return false;
        }

        if (!$this->isOpenEqualClose()) {
            return false;
        }

        if (!$this->isBalanced()) {
            return false;
        }

        return true;
    }
}
