<?php 

require 'vendor/autoload.php';

use Nlazarev\Hw6\Controller\App\EmailValidatorApp;

EmailValidatorApp::init();
EmailValidatorApp::setResultToHTTPHeader();

