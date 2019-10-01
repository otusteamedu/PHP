<?php
use App\validator;
$valid= new validator;
$valid->validate();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<button onclick="redir()">Next Page</button>
    <div id="redirect"></div>
    <script>
    function redir() {
        document.getElementById('redirect').innerHTML =
            '<form style="display:none;" position="absolute" method="post" action="/"><input id="redirbtn" type="submit" name="string" value="(((((((((((((((((((())))))))))))))))))))"></form>';
        document.getElementById('redirbtn').click();
    }
    </script>
</body>
</html>