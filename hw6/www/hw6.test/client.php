<?php 

require 'vendor/autoload.php';

use Nlazarev\Hw6\Model\HTTP\HttpPost;

$URL = "http://192.168.137.60:8080/email_validator.php";
$email_strings_file = "email-strings/in.txt";

$request_postdata = array(
    'email' => 'asnickolaz@gmail.com'
);

$http_post = new HttpPost($request_postdata);

$handle = @fopen($email_strings_file, "r");

if ($handle) {
    while (($buffer = fgets($handle, 4096)) !== false) {
        $request_postdata = array(
            'email' => str_replace(array("\r", "\n"), "", $buffer)
        );
        $http_post->setPostContentValue($request_postdata);
        echo $request_postdata['email'] . " ";
        echo " - " . (($http_post->getPostResult($URL) == "200") ? "Valid" : "Not valid") . "<br>" ;        
    }
    
    if (!feof($handle)) {
        echo "[Error]: Not all emails processed\n";
    }
    
    fclose($handle);
}


