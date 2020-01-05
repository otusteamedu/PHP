<?php

namespace AI\backend_php_hw5_1\Validators;

use AI\backend_php_hw5_1\Exceptions\ValidatorException;


class BracketSequenceValidator implements Validator
{
    /**
     * Проверяет является ли строка правильной скобочной последовательностью.
     * Строка должна состоять только из круглых скобок и быть ненулевой длины.
     *
     * @param string $str
     *
     * @throws ValidatorException
     */
    public function check(string $str): void
    {
        if (empty($str)) {
            throw new ValidatorException('Получена пустая строка');
        }

        if (!$this->isLengthCorrect($str)) {
            throw new ValidatorException('Некорректная длина строки');
        }

        if (!$this->isOnlyBrackets($str)) {
            throw new ValidatorException("Строка должна содержать только скобки '(' и ')'");
        }

        if (!$this->isBracketSequenceCorrect($str)) {
            throw new ValidatorException('Несоответствие открытых и закрытых скобок');
        }
    }

    /**
     * Проверяет является ли длина строки на чётной.
     * Корректной может считаться только строка чётной длины,
     * т.к. каждой открывающейся скобке должна соответствовать закрывающаяся.
     *
     * @param string $str
     *
     * @return bool
     */
    private function isLengthCorrect(string $str): bool
    {
        return (strlen($str) % 2) == 0;
    }

    /**
     * Проверяет состои ли строка только из символов круглых скобок '(' и ')'
     *
     * @param string $str
     *
     * @return bool
     */
    private function isOnlyBrackets(string $str): bool
    {
        return preg_match('/^[\(\)]+$/', $str);
    }

    /**
     * Проверяет является ли скобочная последовательность правильной.
     * Алгоритм взят по ссылке ниже.
     * @url https://neerc.ifmo.ru/wiki/index.php?title=%D0%9F%D1%80%D0%B0%D0%B2%D0%B8%D0%BB%D1%8C%D0%BD%D1%8B%D0%B5_%D1%81%D0%BA%D0%BE%D0%B1%D0%BE%D1%87%D0%BD%D1%8B%D0%B5_%D0%BF%D0%BE%D1%81%D0%BB%D0%B5%D0%B4%D0%BE%D0%B2%D0%B0%D1%82%D0%B5%D0%BB%D1%8C%D0%BD%D0%BE%D1%81%D1%82%D0%B8#.D0.9F.D1.81.D0.B5.D0.B2.D0.B4.D0.BE.D0.BA.D0.BE.D0.B4
     *
     * @param string $str
     *
     * @return bool
     */
    private function isBracketSequenceCorrect(string $str): bool
    {
        $counter = 0;
        for ($i = 0; $i < strlen($str); $i++) {
            if ($str[$i] == '(') {
                $counter++;
            }
            else {
                $counter--;
            }

            if ($counter < 0) {
                return false;
            }
        }

        return $counter == 0;
    }
}
