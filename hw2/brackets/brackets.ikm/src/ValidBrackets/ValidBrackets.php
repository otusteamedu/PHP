<?php
/**
 * Created by PhpStorm.
 * User: rainbow
 * Date: 12.12.20
 * Time: 13:18
 */

namespace ValidBrackets;
use Exception;

class ValidBrackets extends Exception
{
    const HTTP_NOT_VALID = 400;

    private function getError(int $err, int $pos = 0, int $count = 0) {
        $request = '';
        switch ($err) {
            case 1:
                $request = "Скобок нeт!";
                break;
            case 2:
                $request = "В строке неожиданное закрытие скобочки на позиции $pos";
                break;
            case 3:
                $request = "Ожидается закрытие $count скобочек.";
                break;
            default:
                $request = "Неизвестная ошибка!";
                break;
        }

        http_response_code(self::HTTP_NOT_VALID);
        throw new Exception($request, self::HTTP_NOT_VALID);
    }

    public function isValid(string $brackets) {
        $len = mb_eregi_replace('[^()]', '', $brackets);
        $len = strlen($len);
        $count = 0;
        $i = 0;
        $request = '';
        if ( $len > 0 ) {
            $len = strlen($brackets);
            while ($len >= $i) {
                if ($brackets[$i] == ')')
                    $count--;
                elseif ($brackets[$i] == '(')
                    $count++;
                if ($count < 0) break;
                $i++;
            }
            if ($count == 0) $request = "Строка валидна!";
            elseif ($count > 0) self::getError(3, 0,$count);
            elseif ($count < 0) self::getError(2, ++$i, 0);
        } else {
            self::getError(1);
        }

        return "Принятое значение: '".$brackets."'<br/>".$request;
    }
}