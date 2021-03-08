<?php
spl_autoload_register(function ($class_name) {
    include 'app/' . $class_name . '.php';
});

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $example = new CheckPost($_POST);
        $empty = $example->checkEmpty();
        $parentheses = $example->checkParentheses();
        if($empty && $parentheses){
            header('Location:/good');
        }
        
    
    } catch (Exception $e) {
        header('Location:/error');
    }
    
}