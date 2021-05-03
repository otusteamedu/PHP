<?php
session_start();

require_once 'config.php';

try{
    echo (new \Src\App())->run();
} catch (\Exception $exception) {
    echo $exception->getMessage();
}