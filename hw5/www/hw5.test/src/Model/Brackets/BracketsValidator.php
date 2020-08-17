<?php

namespace Nlazarev\Hw5\Model\Brackets;

class BracketsValidator
{
    protected static $brackets_symbols = array("open" => "(", "close" => ")");
    private $brackets_string = null;
    private $brackets_string_length = 0;

    public function __construct(?string $brackets_string)
    {
        $this->brackets_string = $brackets_string;
        $this->brackets_string_length = strlen($brackets_string);
    }

    protected function checkStringLength(): bool
    {
        if ($this->brackets_string_length > 0) {
            return true;
        } else {
            return false;
        }
    }

    protected function checkStringLengthEven(): bool
    {
        if ($this->brackets_string_length % 2 == 0) {
            return true;
        } else {
            return false;
        }
    }

    protected function checkStringCorrectSymbols(): bool
    {
        for ($i=0; $i<$this->brackets_string_length; $i++) {
            if (!in_array($this->brackets_string[$i], static::$brackets_symbols)) {
                return false;
            }
        }

        return true;       
    }

    protected function checkStringCorrectOpenCloseCount(): bool
    {
        $count_open = 0;

        for ($i=0; $i<$this->brackets_string_length; $i++) {
            if ($this->brackets_string[$i] == static::$brackets_symbols["open"]) {
                $count_open++;
            }
        }

        if ($count_open == $this->brackets_string_length / 2) {
            return true;
        } else {
            return false;
        }
    }

    protected function checkStringBalance(int $symb_pos = 0, int $balance = 0): bool
    {
        if ($balance < 0) {
            return false;
        }

        while ($symb_pos < $this->brackets_string_length) {
            if ($this->brackets_string[$symb_pos] == static::$brackets_symbols["open"]) {
                return $this->checkStringBalance(++$symb_pos, ++$balance);
            } elseif ($this->brackets_string[$symb_pos] == static::$brackets_symbols["close"]) {
                return $this->checkStringBalance(++$symb_pos, --$balance);
            } else {
                return false;
            }
        }

        return ($balance == 0);
    }


    public function validateString(bool $precheck = false): bool
    {
        if ($precheck) {
            if (!$this->checkStringLength()) {
                return false;
            }

            if (!$this->checkStringLengthEven()) {
                return false;
            }

            if (!$this->checkStringCorrectSymbols()) {
                return false;
            }

            if (!$this->checkStringCorrectOpenCloseCount()) {
                return false;
            }
        }

        if (!$this->checkStringBalance()) {

            return false;
        }

        return true;

    }
}

