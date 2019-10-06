<?php if ($_POST) {
    require('./class/PostValidator.php');
    $validatePost = new PostValidator();
    $validatePost->run();
    if ($validatePost->getError() == false) {
        header("HTTP/1.1 200 OK");
        echo 'Все хорошо' . PHP_EOL;
    } else {
        header("HTTP/1.1 400 Bad Request");
        echo 'Все плохо' . PHP_EOL;
    }
}

