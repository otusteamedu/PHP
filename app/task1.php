<?php
require __DIR__ . '/CheckPost.php';

$objPost = new \Otus\Azatnizam\CheckPost();

try {
    if ( $objPost->testBody() ) {
        echo 'Post request is successful';
    }
} catch (\Exception $e) {
    header('HTTP/1.1 400 Bad Request');
    echo $e->getMessage();
}
