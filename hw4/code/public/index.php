<?php

// POST processing
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(empty($_POST['string'])) {
        $error = 'Строка не может быть пустой';
    } elseif(strlen($_POST['string']) < 2 || strlen($_POST['string']) > 256) {
        $error = 'Не корректная длина строки';
    } elseif (strlen(str_replace(')', '', str_replace('(', '', $_POST['string']))) > 0) {
        $error = 'Строка содержит символы, отличные от скобкок';
    } else {
        // Check bracket sequence
        $bracketCount = 0;
        for($i = 0; $i < strlen($_POST['string']); $i++) {
            if($_POST['string'][$i] === '(') {
                $bracketCount++;
            } else {
                $bracketCount--;
            }
        }
        if($bracketCount !== 0) {
            $error = 'Не верное количество открытых и закрытых скобок';
        } else {
            $success = 'Количество открытых и закрытых скобок совпадает';
        }
    }
}

if(isset($error)) {
    http_response_code(400);
}

// Render the page
include_once('client.php');