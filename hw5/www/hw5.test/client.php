<?php 

require 'vendor/autoload.php';

use Nlazarev\Hw5\Model\HTTP\HttpPost;

$URL = "http://192.168.137.60:8080/index.php"; 

$request_postdata = array(
    'string' => '(()'
);

$http_request = array(
    'http' => 
        array(
        'method'  => "POST", 
        'header'  => "Content-type: application/x-www-form-urlencoded " 
                    ."Content-Length: 48",
        'content' => http_build_query($request_postdata)
    )
);

$http_post = new HttpPost($http_request);

echo $http_post->getPostResult($URL);
