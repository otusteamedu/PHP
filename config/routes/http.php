<?php
/**
 * Here is a place for the http routes.
 */
return [
    'post@/' => 'HomeController@index',
    'post@/email/verify' => 'HomeController@verifyEmail'
];
