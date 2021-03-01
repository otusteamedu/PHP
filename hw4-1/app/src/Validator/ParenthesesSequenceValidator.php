<?php

declare(strict_types=1);

namespace App\Validator;

class ParenthesesSequenceValidator
{

    public function validate(string $value): bool
    {
        $count = 0;

        for ($i = 0; $i < strlen($value); $i++) {
            $char = $value[$i];

            if ($char === '(') {
                $count++;
            } elseif ($char === ')') {
                $count--;
            }

            if ($count < 0) {
                // Найдена закрывающая скобка, для которой нет соответствующей открывающей скобки
                return false;
            }
        }

        //Если $count не нулевой, значит есть открывающиеся скобки, для которых нет соответствующих закрывающихся скобок
        return ($count === 0);
    }

}