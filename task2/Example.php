<?php
/**
 * @author Dima Baldin <baldin@tutu.ru>
 *
 * @description пример использования пакета
 */
require_once 'vendor/autoload.php';

use Code\Simple;

var_dump(Simple::isSimple(31));
var_dump(Simple::isSimple(28));
var_dump(Simple::isSimple('aaaaa'));