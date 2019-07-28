<?php
/** Sample controller
*
* @version SVN: $Id: Sample.php 1331 2018-08-28 02:51:34Z anrdaemon $
*/

namespace AnrDaemon\CcWeb\Controllers;

use AnrDaemon\CcWeb\Exceptions;
use AnrDaemon\CcWeb\Interfaces;

class Sample
implements Interfaces\Controller
{
  use \AnrDaemon\CcWeb\Helpers\ControllerBase;

// Helpers\ControllerBase

  protected function validateMetadata($meta = null) {}

// Interfaces\Controller

  public function run(/*TODO:PHP7 string */$uri = null)
  {
    header('Content-Type: text/plain');

    print "Please POST your list for validation (one address per line)";
  }
}
