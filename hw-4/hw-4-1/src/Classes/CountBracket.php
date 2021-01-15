<?php


namespace Classes;


class CountBracket
{

//    // Проверяем количество открывающих скобок. Если соответствует указанному значению, возвращаем true.
//    public static function brackets_count ($string)
//    {
//        $arr = trim($string);
//
//        if ( substr_count($arr, '(') > 0 && substr_count($arr, ')') > 0 ) {
//            return true;
//        }
//
//        return false;
//    }
    // Цель функции в том, чтобы создать два массива с открывающими и закрывающими скобками.
    // Сначала создаём массив с открывающими скобками и сравниваем с закрывающими перебором,
    // извлекая каждый раз из массива открывающих скобок при совпадении элемент.
    // Таким образом, если открывающие и закрывающие совпадают, мы получаем пустой массив и возвращаем true.
    // При этом если открывающие скобки в массиве есть, а есть закрывающих нет, или наоборот, возвращаем false.
    function brackets_count($string, $bracket_map = false) {
        // Указываем массив элементов, которые будут проверяться на валидность.
        $bracket_map = $bracket_map ?: [ '(' => ')' ];
        // Меняем местами ключ и значение.
        $bracket_map_flipped = array_flip($bracket_map);
        // Получаем длину проверяемой строки.
        $length = mb_strlen($string);
        //
        $brackets_stack = [];
        for ($i = 0; $i < $length; $i++) {
            // Получаем каждый элемент строки.
            $current_char = $string[$i];
            // Сравниваем элемент строки с заданным массивом в $bracket_map.
            if (isset($bracket_map[$current_char])) {
                // Если элемент в строке соответствует значению в массиве $bracket_map
                // записываем его в массив $brackets_stack
                $brackets_stack[] = $bracket_map[$current_char];
            // Если первая проверка не проходит, сравниваем значение второго массива $bracket_map_flipped
            } else if (isset($bracket_map_flipped[$current_char])) {
                $expected = array_pop($brackets_stack);
                // Извлекаем значение из $brackets_stack и сравниваем его со значением из строки.
                // По факту, мы проверяем наличие закрытой скобки, если уже существует открытая.
                // Если закрывающей или открывающей скобки нет, возвращаем false.
                if (($expected === NULL) || ($current_char != $expected)) {
                    return false;
                }
            }
        }
        // Если массив пуст, значит открытые и закрытые скобки совпали и мы возвращаем true.
        return empty($brackets_stack);
    }

}