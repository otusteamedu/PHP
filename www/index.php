<?php
$string = '((()))';
$runfile = 'http://nginx/query.php';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $runfile);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, ['string' => $string]);

$content = curl_exec ($ch);
if(curl_errno($ch)) {
	echo 'Curl error: '.curl_error($ch);
}
curl_close ($ch);

if ( $content ) {
	http_response_code(200);
	echo 'Все хорошо';
} else {
	http_response_code(400);
	echo 'Все плохо';
}


