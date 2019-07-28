<?php
/** Sample controller
*
* @version SVN: $Id$
*/

namespace AnrDaemon\CcWeb\Controllers;

use AnrDaemon\CcWeb\Exceptions;
use AnrDaemon\CcWeb\Interfaces;

class ValidateAddress
implements Interfaces\Controller
{
  use \AnrDaemon\CcWeb\Helpers\ControllerBase;

// Helpers\ControllerBase

  protected function validateMetadata($meta = null) {}

// Interfaces\Controller

  public function run($uri = null)
  {
    header('Content-Type: text/plain');

    $validator = new \AnrDaemon\Validator\EmailAddress;

    $stream = fopen("php://input", "rb");
    if($stream === false || false === rewind($stream))
    {
      print "ERROR: unable to read input";
    }

    while(strlen($string = trim(fgets($stream, 4096))))
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
  }
}
