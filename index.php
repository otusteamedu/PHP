<?php

$client_id = '899632747294-df8fm6buohraml1gq9lj67anio1lsgqi.apps.googleusercontent.com';
$client_secret = 'oMOhUtKGwhQIfkVyHIeOScyC';
$refresh_token = '1/0ETQq8vdh4ilfOks8Z6GDBOf1Bdrc9vjFjOJUm2ddF3SOEoY4GPYr2jydUg99Acu';

/*
AIzaSyACWPYIAtO_uRktd31oSJamVZWZtOsTLEY

id
899632747294-df8fm6buohraml1gq9lj67anio1lsgqi.apps.googleusercontent.com
sec
oMOhUtKGwhQIfkVyHIeOScyC

authcode
4/rQHCDSJmttBLkzXRkOSVt7bNy01eZuST4Vs5uIijLTu4JpTO_RP7qD_Fo0BNRAgl_ZC1Uq0QhCX4TnJKoZzuXbs

POST /oauth2/v4/token HTTP/1.1
Host: www.googleapis.com
Content-length: 322
content-type: application/x-www-form-urlencoded
user-agent: google-oauth-playground
code=4%2FrQHCDSJmttBLkzXRkOSVt7bNy01eZuST4Vs5uIijLTu4JpTO_RP7qD_Fo0BNRAgl_ZC1Uq0QhCX4TnJKoZzuXbs&redirect_uri=https%3A%2F%2Fdevelopers.google.com%2Foauthplayground&client_id=899632747294-df8fm6buohraml1gq9lj67anio1lsgqi.apps.googleusercontent.com&client_secret=oMOhUtKGwhQIfkVyHIeOScyC&scope=&grant_type=authorization_code


/* how to get new access token
https://www.googleapis.com/oauth2/v4/token with following request body

client_id: <YOUR_CLIENT_ID>
client_secret: <YOUR_CLIENT_SECRET>
refresh_token: <REFRESH_TOKEN_FOR_THE_USER>
grant_type: refresh_token



refresh
1/0ETQq8vdh4ilfOks8Z6GDBOf1Bdrc9vjFjOJUm2ddF3SOEoY4GPYr2jydUg99Acu
access
ya29.GluJB-qiSaji-aof4_Coci0Nad6tGzF9O2YZ6qicSkQGfgT11H5KyDERUPhPlcoqLGfWC7ZRt43BgMGnPQOkhDZL8z5TtEr5UsT3-XTE_JIDjEz3SAeomzu_yvNm


https://www.youtube.com/watch?time_continue=236&v=hfWe1gPCnzc


channel_id = UCKPOPqWjusw4tk1k0tqzVnA
*/

/**
 * Sample PHP code for youtube.channels.list
 * See instructions for running these code samples locally:
 * https://developers.google.com/explorer-help/guides/code_samples#php
 */

/**
 * Sample PHP code for youtube.channels.list
 * See instructions for running these code samples locally:
 * https://developers.google.com/explorer-help/guides/code_samples#php
 */

if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    throw new Exception(sprintf('Please run "composer require google/apiclient:~2.0" in "%s"', __DIR__));
}
require_once __DIR__ . '/vendor/autoload.php';

//get data from youtube
$client = new Google_Client();
$client->setApplicationName('API code samples');
$client->setScopes([
    'https://www.googleapis.com/auth/youtube.readonly',
]);

//how to get keys https://cloud.google.com/iam/docs/creating-managing-service-account-keys
$client->setAuthConfig('client_secret_899632747294-df8fm6buohraml1gq9lj67anio1lsgqi.apps.googleusercontent.com.json');
$client->setAccessType('offline');


// Exchange authorization code for an access token.
//$accessToken = '1/0ETQq8vdh4ilfOks8Z6GDBOf1Bdrc9vjFjOJUm2ddF3SOEoY4GPYr2jydUg99Acu';//this is refresh token
//$client->fetchAccessTokenWithAuthCode($authCode);
$client->fetchAccessTokenWithRefreshToken($refresh_token);

// Define service object for making API requests.
$service = new Google_Service_YouTube($client);

/*
$queryParams = [
    'forUsername' => 'SiliconValleyVoice'
];
$response = $service->channels->listChannels('id,statistics,contentDetails,contentOwnerDetails,topicDetails', $queryParams);
*/

$queryParams = [
    'chart' => 'mostPopular',
    //'pageToken' => 'CAUQAA',
    'maxResults' => 100
];

$response = $service->videos->listVideos('statistics,snippet', $queryParams);



echo '<pre>';
print_r($response);
echo '</pre>';



//checking Mongo
$collection = (new MongoDB\Client)->youtube->channels;

/*$insertOneResult = $collection->insertOne([
    'username' => 'admin',
    'email' => 'admin@example.com',
    'name' => 'Admin User',
]);

printf("Inserted %d document(s)\n", $insertOneResult->getInsertedCount());

var_dump($insertOneResult->getInsertedId());*/

$document = $collection->findOne(['name' => 'Admin User']);

$res = $collection->deleteOne(['name' => 'Admin User']);
var_dump($res->getDeletedCount());


exit;






