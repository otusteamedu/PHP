<?php

spl_autoload_register(static function ($class) {
    include '../src/' . str_replace('\\', '/', $class) . '.php';
});
