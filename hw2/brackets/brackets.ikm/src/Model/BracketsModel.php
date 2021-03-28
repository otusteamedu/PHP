<?php
/**
 * Created by PhpStorm.
 * User: rainbow
 * Date: 12.12.20
 * Time: 13:18
 */

namespace ValidBrackets\Model;
use Exception;

class BracketsModel extends Exception
{
    const HTTP_NOT_VALID = 400;
    private $count, $numb;

    private function setCount($i){
        $this->count = $i;
    }
    private function setNumb($i){
        $this->numb = $i;
    }
    public function getCount(){
        return $this->count;
    }
    public function getNumb(){
        return $this->numb;
    }

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

    private function isValid(string $brackets, int $len):bool {
        $count = 0;
        $i = 0;
        $len = strlen($brackets);
        while ($len >= $i) {
            if ($brackets[$i] == ')')
                $count--;
            elseif ($brackets[$i] == '(')
                $count++;
            if ($count < 0) break;
            $i++;
        }
        if ($count !== 0) {
            self::setCount($count);
            self::setNumb(++$i);
            return false;
        } else
            return true;
    }

    public function check($str){
        try {
            $len = mb_eregi_replace('[^()]', '', $str);
            $len = strlen($len);
            if ($len <= 0) self::getError(1);
            
            if (!self::isValid($str, $len))
                self::getError((self::getCount() < 0 ? 2 : 3), self::getNumb(), self::getCount());
            
            return "Строка валидна!";
        } catch(Exception $e) {
            return $e->getMessage();
        }
    }
}