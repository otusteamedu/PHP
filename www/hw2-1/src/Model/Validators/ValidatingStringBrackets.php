<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\Validators;

class ValidatingStringBrackets extends ValidatingString
{
    protected $brackets_symbols = array("open" => "(", "close" => ")");

    public function __construct(?string $brackets_string)
    {
        parent::__construct($brackets_string);
    }

    protected function isCorrectSymbols(): bool
    {
        $len = $this->getLength();
        $str = $this->getValue();

        for ($pos = 0; $pos < $len; $pos++) {
            if (!in_array($str[$pos], $this->brackets_symbols)) {
                return false;
            }
        }

        return true;
    }

    protected function isOpenEqualClose(): bool
    {
        $len = $this->getLength();
        $str = $this->getValue();

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

        $len = $this->getLength();
        $str = $this->getValue();
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


    public function validate(bool $precheck = false): bool
    {
        if ($precheck) {
            if ($this->isEmpty()) {
                return false;
            }

            if (!$this->isLengthEven()) {
                return false;
            }

            if (!$this->isCorrectSymbols()) {
                return false;
            }

            if (!$this->isOpenEqualClose()) {
                return false;
            }
        }

        if (!$this->isBalanced()) {
            return false;
        }

        return true;
    }
}
