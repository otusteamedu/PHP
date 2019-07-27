#!/usr/bin/env php
<?php

require __DIR__ . "/vendor/autoload.php";

$validator = new \AnrDaemon\Validator\EmailAddress;
while(strlen($string = trim(fgets(STDIN, 4096))))
{
  try
  {
    if($validator->validate($string))
    {
      print "SUCCESS: '{$string}' appears to be valid email address.\n";
    }
  }
  catch(\UnexpectedValueException $e)
  {
    print "VALIDATION ERROR: {$e->getMessage()}\n";
  }
}
