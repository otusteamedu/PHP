<?php
function autoloader($class){
    $fullFileName = __DIR__.'/'.$class.'.php';
    if (file_exists($fullFileName)) {
        include $fullFileName;
    }
}

spl_autoload_register('autoloader');
