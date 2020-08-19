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
    <input type="text" name="string" pattern="^[()]+$" placeholder="Enter string here..." title="Only ( and )">
    <input type="submit" placeholder="enter">
</form>
</body>
</html>
<?php

if(isset($_POST['string']))
{
    $string = htmlspecialchars($_POST['string']);
    $numSym = mb_strlen($string);

    if(($numSym % 2) !== 0) {
        http_response_code(400);
        echo 'Everything is bad!';
    } else {
        $numSym1 = mb_substr_count('(', $string);
        if(($numSym - $numSym1) === 0){
            http_response_code(200);
            echo 'Everything is ok!';
        } else {
            http_response_code(400);
            echo 'Everything is bad!';
        }
    }
}
