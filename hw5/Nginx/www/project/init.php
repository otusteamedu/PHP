<?php
declare(strict_types = 1);

spl_autoload_register('autoload');
function autoload($className)
{
    $fileName = 'libraries/' . $className . '.class.php';
    require_once($fileName);
}