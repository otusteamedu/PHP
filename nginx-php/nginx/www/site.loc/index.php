<?php
//минимальная длина строки
$minLength = 10;
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Homework 2-1</title>
</head>
<body>
<h3>Please enter string and click to the button</h3>
<form action="/" method="post">
    <input type="text" name="string" pattern="^[()]+$" placeholder="Enter string here..." title="Only ( and ), also > <?="$minLength";?>">
    <input type="submit" placeholder="enter">
</form>
</body>
</html>

<?php

//выполняем скрипт, если отправлен POST запрос
if (!empty($_POST['string'])) {
    $string = htmlspecialchars($_POST['string']);
    $countSymbols = mb_strlen($string);

    if (($countSymbols % 2) !== 0) {
        http_response_code(400);
        echo 'Everything is bad!';
        return;
    }

    if(mb_substr($string, 0, 1) === ')' || mb_substr($string, $countSymbols - 1, 1) === '(') {
        http_response_code(400);
        echo 'Everything is bad!';
        return;
    }

    $countSymbol1 = mb_substr_count($string, '(');
    if (($countSymbols - $countSymbol1) === $countSymbol1) {
        http_response_code(200);
        echo 'Everything is ok!';
        return;
    } else {
        http_response_code(400);
        echo 'Everything is bad!';
        return;
    }
}

?>