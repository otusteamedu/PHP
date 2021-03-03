<?php 

namespace Otus\Checker;

final class Checker
{
    public function __construct($string) {
    	$this->string = $string;
    }

    public function hooks() {
    	// Сравнение количества открытых и закрытых скобок
		$str_cor = substr_count($this->string, '(') != substr_count($this->string, ')') ? false : true;
		// Если количество одинаковое, проверяем корректность
		if($str_cor){
			$bkt = 0;
			foreach(str_split($this->string) as $symb){
				switch ($symb) {
					case '(':
						$bkt++;
						break;
					case ')':
						$bkt--;
						break;
				}
				if($bkt < 0) break;
			}
			if($bkt != 0) $str_cor = false;
		}
		$str_msg = $str_cor ? 'Все открытые скобки закрыты' : 'Ошибка! В строке присутствуют незакрытые скобки';

		return $str_msg;
    }
}