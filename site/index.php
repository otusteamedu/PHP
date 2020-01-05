<?php

$server_ip =  $_SERVER['SERVER_ADDR'];

$emails = $_POST["emails"];

$arr = explode("\n", $emails);

function check_email_reg($email) {
    $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);

    if (filter_var($emailB, FILTER_VALIDATE_EMAIL) === false ||
        $emailB != $email
    ) {
        return false;
    }
    return true;
}

function check_email_mx($email) {
    list($user, $domain) = explode('@', $email);
    $arr= dns_get_record($domain,DNS_MX);
    if($arr[0]['host']==$domain&&!empty($arr[0]['target'])){
        return $arr[0]['target'];
    }
}
echo "Server IP : ".$server_ip."<br />";
echo "<pre>";
foreach($arr as $e) {
    if(trim($e) != "") {
        echo $e."\t".check_email_reg($e)."\t".check_email_mx($e)."\n";
    }
}

echo "<pre>";