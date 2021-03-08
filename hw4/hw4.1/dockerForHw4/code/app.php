<?php
spl_autoload_register(function ($class_name) {
    include 'app/' . $class_name . '.php';
});
// require 'app/CheckPost.php';
// use App\CheckPost;
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $example = new CheckPost($_POST);
        $empty = $example->checkEmpty();
        $parentheses = $example->checkParentheses();
        // header('200 OK', true, 200);
        if($empty && $parentheses){
            // header("Status:200 OK");
            // header("Status: 200 OK", false, 200);
            // header('200 OK', true, 200);
            header('Location:/good');
        }
        
    
    } catch (Exception $e) {
        // header('400 Bad Request');
        // header('HTTP/1.1 400 Bad Request', true, 400);
        header('Location:/error');
    }
    
}