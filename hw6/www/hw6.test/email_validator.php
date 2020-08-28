<?php 

require 'vendor/autoload.php';

use Nlazarev\Hw6\Controller\Email\EmailValidator;

EmailValidator::init();
EmailValidator::setResultToHTTPHeader();

